<?php
// Dana Geßler 30.4.2020

class ErgebnisView extends Ergebnis
{

    public function showFragebogenBenutzerKurs($Fragebogen, $Kurs)
    { 
    }

    //Aufruf getKommentareStmt
    public function showKommentare($Fragebogen, $Kurs){
      //  $kommentarArray = $this->kommentarArray;
      $alleKommentare =  $this->getKommentareStmt($Fragebogen, $Kurs);
    //    $alleKommentare = $kommentarArray; 
       return $alleKommentare;
    }

    public function showBerechnungenJeFragejeKurs($Fragebogen, $Kurs)
    {   
    // Aufrufe für Antworten (avg, min, max, standDev)
  //      $avgAnswer = $this->avgAnswer;
         $avgAnswer = $this->getAvgAnswerStmt($Fragebogen, $Kurs);
         if ($avgAnswer == null ){
          header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
          }
 //       $minAnswer = $this->minAnswer;
        $minAnswer =   $this->getMinAnswerStmt($Fragebogen, $Kurs);
        if ($minAnswer == null ){
          header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
          }
  //      $maxAnswer = $this->maxAnswer;
        $maxAnswer = $this->getMaxAnswerStmt($Fragebogen, $Kurs);
        if ($maxAnswer == null ){
          header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
          }
   //     $standDev = $this->standDev;
        $standDevArray = $this->getStandDevArrayStmt($Fragebogen, $Kurs);
        if ($standDevArray == null ){
          header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
              }
          elseif ($standDevArray !== null ){
            $num_elem = count($standDevArray);
            $abweichung = 0.0;
            $avg = array_sum($standDevArray)/$num_elem;
            foreach($standDevArray as $i){
            $abweichung += pow(($i - $avg), 2);
         }
         $standDev = (float)sqrt($abweichung/$num_elem);



        $auswertung = array($avgAnswer, $minAnswer, $maxAnswer, $standDev);

      return $auswertung;

        
    }
}
}