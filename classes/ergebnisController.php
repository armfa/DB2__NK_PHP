<?php
// Dana Geßler 11.05.2020
class ErgebnisView extends Ergebnis
{



  //Aufruf getKommentareStmt
  function showKommentare($Fragebogen, $Kurs)
  {
    $kommentarString = "";
    //  $kommentarArray = $this->kommentarArray;
    try {
      $alleKommentare =  $this->getKommentareStmt($Fragebogen, $Kurs);
      //    $alleKommentare = $kommentarArray; 

      if ($alleKommentare == null) {
        $kommentarString = "Kein Student hat einen Kommentar abgegeben!";
      } elseif ($alleKommentare !== null) {
        $kommentarString = '';
        foreach ($alleKommentare as $kommentar) {
          $kommentarString = $kommentarString . $kommentar['Kommentar'];
          if ($kommentarString != '') $kommentarString = $kommentarString . "<br><br>";
        }
      }
      return $kommentarString;
    } catch (PDOException $e) {
      header("Location: ../DB2__NK_PHP/indexFehler.php");
      exit();
    }
  }

  function structureBerechnungenJeFragejeKurs($Fragebogen, $Kurs)
  {
    try {
      $auswertung = array();

      // Aufrufe für Antworten, Abspeicherung in Arrays (avg, min, max, standDev)

      //Durchschnittsantworten
      $avgAnswers = $this->getAvgAnswerStmt($Fragebogen, $Kurs);
      if ($avgAnswers == null) {
        // header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
      } elseif ($avgAnswers !== null) {
        foreach ($avgAnswers as $row) {
          if ($auswertung == null) {
            $auswertung[$row['Fragenummer']] = array('avgAnswer' => $row["avg(bean.Antwort)"]);
          } else {
            $auswertung[$row['Fragenummer']]['avgAnswer'] = $row["avg(bean.Antwort)"];
          }
        }
      }

      //Minimale Antwort
      $minAnswer =   $this->getMinAnswerStmt($Fragebogen, $Kurs);
      if ($minAnswer == null) {
        // header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
      } elseif ($minAnswer !== null) {
        foreach ($minAnswer as $row) {
          $auswertung[$row['Fragenummer']]['minAnswer'] = $row["min(bean.Antwort)"];
        }
      }

      //Maximale Antwort
      $maxAnswer = $this->getMaxAnswerStmt($Fragebogen, $Kurs);
      if ($maxAnswer == null) {
        //  header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
      } elseif ($maxAnswer !== null) {
        foreach ($maxAnswer as $row) {
          $auswertung[$row['Fragenummer']]['maxAnswer'] = $row["max(bean.Antwort)"];
        }
      }

      //Abspeicherung der Daten für die Berechnung der Standardabweichungen in multidim. Array
      $standDevArray = $this->getStandDevArrayStmt($Fragebogen, $Kurs);

      if ($standDevArray == null) {
        //  header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
      } elseif ($standDevArray !== null) {
        $fragenummern = array();
        $antworten = array(array());

        //Fragenummern suchen
        foreach ($standDevArray as $row) {
          if (!in_array($row['Fragenummer'], $fragenummern)) {
            array_push($fragenummern, $row['Fragenummer']);
          }
        }

        $index = 0;
        // Antworten zu zugehörigen Fragenummern gliedern
        // Bsp.: $antworten[0] gibt die antworten zurück, die zu $fragenummern[0] gehören
        for ($i = 0; $i < count($standDevArray); $i++) {
          for ($j = 0; $j < count($fragenummern); $j++) {
            if ($fragenummern[$j] == $standDevArray[$i]['Fragenummer']) {
              $index = $j;
            }
          }
          $antworten[$index][] = $standDevArray[$i]['Antwort'];
        }


        //Standardabweichung pro Fragenummer berechnen (+Ausgabe)
        for ($i = 0; $i < count($antworten); $i++) {

          $standDev = $this->calculateStandDev($antworten[$i]);

          $auswertung[$fragenummern[$i]]['standDev'] = $standDev;
        }
      }

      // {19 : {"avgAnswer":wert; "minAnswer":wert; "maxAnswer":wert; "standDev":wert}; 20 : {"minAnswer":wert; ...} }
      //$auswertung = array($avgAnswers, $minAnswer, $maxAnswer, $standDev);

      return $auswertung;
    } catch (PDOException $e) {
      header("Location: ../DB2__NK_PHP/indexFehler.php");
      exit();
    }
  }


  function displayValues($auswertung, $type, $fragebogen)
  {
    try {
      $fragenummerInhaltFrage = $this->getInhaltFrage($fragebogen);
      //var_dump($fragenummerInhaltFrage);
      $fragenindex = 0;
      for ($i = 0; $i < count($fragenummerInhaltFrage); $i++) {


        echo $fragenummerInhaltFrage[$i]['InhaltFrage'] . ": ";
        //echo " - ".$fragenummerInhaltFrage[$i]['Fragenummer']." - ";

        //If statement: existiert eine Antwort zu der Frage?
        if ($fragenindex < count(array_keys($auswertung))) {
          echo $auswertung[$fragenummerInhaltFrage[$i]['Fragenummer']][$type];
          $fragenindex++;
        } else {
          echo "Diese Frage wurde noch nicht beantwortet!";
        }

        echo "<br>";
      }
    } catch (PDOException $e) {
      header("Location: ../DB2__NK_PHP/indexFehler.php");
      exit();
    }
  }

  //Funktion zur Berechnung der Standardabweichung
  function calculateStandDev($eingabeWerte)
  {
    try {
      $num_elem = count($eingabeWerte);
      $abweichung = 0.0;
      $avg = array_sum($eingabeWerte) / $num_elem;
      foreach ($eingabeWerte as $j) {
        $abweichung += pow(($j - $avg), 2);
      }
      return (float) sqrt($abweichung / $num_elem);
    } catch (PDOException $e) {
      header("Location: ../DB2__NK_PHP/indexFehler.php");
      exit();
    }
  }
}
