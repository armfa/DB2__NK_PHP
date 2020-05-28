<?php
// Dana Geßler 11.05.2020
//______________________KLASSENBESCHREIBUNG______________________
// Das Ziel dieser Klasse ist die Verarbeitung der Datenbankwerte zur Speicherung der Auswertungsergebnisse in einem Array mit Darstellung
// showKommentare() --> Befüllung des Kommentarstrings. Iteration durch den Kommentararray aus der Datenbank, nach jedem Kommentar Leerzeile.
//                      Wenn keine Kommentare vorhanden, entsprechende Ausgabe
// structureBerechnungenJeFragejeKurs() --> Strukturierung von avg, min, max, standDev in einem Ergebnis-Array. 
// displayValues() --> Zur Darstellung der Antworten je Frage. Ausgabe über Frageninhalt, da Fragekürzel nicht aussagekräftig ist.
// calculateStandDev() --> Funktion zur Berechnung der Standardabweichung


class ErgebnisView extends Ergebnis
{
  function showKommentare($Fragebogen, $Kurs)
  {
    $kommentarString = "";
    try {
      $alleKommentare =  $this->getKommentareStmt($Fragebogen, $Kurs);

      if ($alleKommentare == null) {
        $kommentarString = "Kein Student hat einen Kommentar abgegeben!";
      } elseif ($alleKommentare != null) {
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
      foreach ($avgAnswers as $row) {
        if ($auswertung == null) {
          $auswertung[$row['Fragenummer']] = array('avgAnswer' => $row["avg(bean.Antwort)"]);
        } else {
          $auswertung[$row['Fragenummer']]['avgAnswer'] = $row["avg(bean.Antwort)"];
        }
      }


      //Minimale Antwort
      $minAnswer =   $this->getMinAnswerStmt($Fragebogen, $Kurs);
      foreach ($minAnswer as $row) {
        $auswertung[$row['Fragenummer']]['minAnswer'] = $row["min(bean.Antwort)"];
      }


      //Maximale Antwort
      $maxAnswer = $this->getMaxAnswerStmt($Fragebogen, $Kurs);
      foreach ($maxAnswer as $row) {
        $auswertung[$row['Fragenummer']]['maxAnswer'] = $row["max(bean.Antwort)"];
      }


      //Abspeicherung der Daten für die Berechnung der Standardabweichungen in multidim. Array
      $standDevArray = $this->getStandDevArrayStmt($Fragebogen, $Kurs);

      if ($standDevArray == null) {
        // Do nothing
      } elseif ($standDevArray != null) {
        $fragenummern = array();
        $antworten = array(array());

        //Distinct Fragenummern suchen, da es zu einer Fragenummer meherere Antworten geben kann
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


        //Standardabweichung pro Fragenummer berechnen + Speicherung is auswertung-Array
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
      $fragenindex = 0;
      for ($i = 0; $i < count($fragenummerInhaltFrage); $i++) {

        // Ausgabe von Frageinhalt, da Fragenummer (in DB Kürzel nur zur internen Verarbeitung) nicht aussagekräftig ist und der Nutzer den Inhalt der Frage anhand des Kürzels nicht sofort erkennen kann
        echo $fragenummerInhaltFrage[$i]['InhaltFrage'] . ": ";

        //If statement: existiert eine Antwort zu der Frage?
        //wenn ja, entsprechende Ausgabe aus Ergebnisarray
        //nur bis dahin, wo noch Fragen vorhanden sind

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
  //Funktion zur Berechnung der Standardabweichung (Standardabweichung = Streuungsmaß. --> Umfang der Abweichung der Daten vom Durchschnittswert)
  // 1. Durchschnitt berechnen
  // 2. Differenz von jedem Wert zum Durchschitt berechnen & Ergebnis quadrieren, addieren in $abweichung
  // 3. quadrierte Differenz durch Anzahl Ergebnisse dividieren und davon Wurzel ziehen

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
