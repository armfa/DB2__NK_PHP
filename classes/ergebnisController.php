<?php
// Dana Geßler 30.4.2020

class ErgebnisView extends Ergebnis
{

  /*public function showFragebogenBenutzerKurs($Fragebogen, $Kurs)
  { 
  }*/

  //Aufruf getKommentareStmt
  function showKommentare($Fragebogen, $Kurs){
    $kommentarString = "";
    //  $kommentarArray = $this->kommentarArray;
    $alleKommentare =  $this->getKommentareStmt($Fragebogen, $Kurs);
    //    $alleKommentare = $kommentarArray; 

    if ($alleKommentare == null ){
        // header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noComments");
    }  elseif ($alleKommentare !== null){
        $kommentarString = '';
        foreach($alleKommentare as $kommentar){
            $kommentarString = $kommentarString.$kommentar['Kommentar'];
            If ($kommentarString != '') $kommentarString = $kommentarString."<br>";
        }
    }
    return $kommentarString;
  }

  public function structureBerechnungenJeFragejeKurs($Fragebogen, $Kurs)
  {   

    // Aufrufe für Antworten (avg, min, max, standDev)
    // $avgAnswer = $this->avgAnswer;
    $avgAnswers = $this->getAvgAnswerStmt($Fragebogen, $Kurs);
    if ($avgAnswers == null ){
      // header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
    } elseif($avgAnswers !== null ){
      foreach($avgAnswers As $row){
        $auswertung[$row['Fragenummer']]['avgAnswer'] = $row["avg(bean.Antwort)"];
      }

    }
    // $minAnswer = $this->minAnswer;
    $minAnswer =   $this->getMinAnswerStmt($Fragebogen, $Kurs);
    if ($minAnswer == null ){
      // header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
    }elseif($minAnswer !== null ){
      foreach($minAnswer As $row){
        $auswertung[$row['Fragenummer']]['minAnswer'] = $row["min(bean.Antwort)"];
      }
    }

    // $maxAnswer = $this->maxAnswer;
    $maxAnswer = $this->getMaxAnswerStmt($Fragebogen, $Kurs);
    if ($maxAnswer == null ){
      //  header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
    }elseif($maxAnswer !== null ){
      foreach($maxAnswer As $row){
        $auswertung[$row['Fragenummer']]['maxAnswer'] = $row["max(bean.Antwort)"];
      }
    }

    // $standDev = $this->standDev;
    $standDevArray = $this->getStandDevArrayStmt($Fragebogen, $Kurs);
    if ($standDevArray == null ){
    //  header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
    } elseif ($standDevArray !== null ){
      $fragenummern = array();
      $antworten = array(array());
  
      //Fragenummern suchen
      foreach ($standDevArray as $row){
        if( !in_array($row['Fragenummer'], $fragenummern)){ 
            array_push($fragenummern,$row['Fragenummer'] );
        }
      }  

      $index = 0;
      // Antworten zu zugehörigen Fragenummern gliedern
      // Bsp.: $antworten[0] gibt die antworten zurück, die zu $fragenummern[0] gehören
      for ($i = 0; $i<count($standDevArray); $i++){
        for($j = 0; $j< count($fragenummern); $j++){
          if($fragenummern[$j] == $standDevArray[$i]['Fragenummer']){
              $index = $j; 
          }
        }
        $antworten[$index][] = $standDevArray[$i]['Antwort'];
      }
    
    
      //Standardabweichung pro Fragenummer berechnen (+Ausgabe)
      for ($i = 0; $i<count($antworten); $i++){
          
        $standDev = calculateStandDev($antworten[$i]);
      
        $auswertung[$fragenummern[$i]]['standDev'] = $standDev;
      }

    }

    // {19 : {"avgAnswer":wert; "minAnswer":wert; "maxAnswer":wert; "standDev":wert}; 20 : {"minAnswer":wert; ...} }
    //$auswertung = array($avgAnswers, $minAnswer, $maxAnswer, $standDev);

    return $auswertung;
  }

  function displayValues($ergebnisArray, $type, $fragebogen) {
    For ($i = 0; $i < count(array_keys($ergebnisArray)); $i++){
                  
      $fragenummerInhaltFrage = $this->getInhaltFrage($fragebogen);

      echo $fragenummerInhaltFrage[$i]['InhaltFrage'].": ";

      echo $ergebnisArray[$fragenummerInhaltFrage[$i]['Fragenummer']][$type];
  
      echo "<br>";
  }
  }

}

function calculateStandDev($eingabeWerte) {
  $num_elem = count($eingabeWerte);
  $abweichung = 0.0;
  $avg = array_sum($eingabeWerte)/$num_elem;
  foreach($eingabeWerte as $j){
    $abweichung += pow(($j - $avg), 2);
  }
  return (float)sqrt($abweichung/$num_elem);
}

//1. Keine Kommentare (Meldung)
//2. Fehler keine Antworten
//

