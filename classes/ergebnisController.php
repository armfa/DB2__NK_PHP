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

    if ($alleKommentare == null ){
     // header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noComments");
      }  elseif ($alleKommentare !== null){
      $ausgabe = implode("<br>\n",$alleKommentare);
       return $ausgabe;
    }}

    public function showBerechnungenJeFragejeKurs($Fragebogen, $Kurs)
    {   
    // Aufrufe für Antworten (avg, min, max, standDev)
  //      $avgAnswer = $this->avgAnswer;
         $avgAnswer = $this->getAvgAnswerStmt($Fragebogen, $Kurs);
         if ($avgAnswer == null ){
         // header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
          } elseif($avgAnswer !== null ){


          }
 //       $minAnswer = $this->minAnswer;
        $minAnswer =   $this->getMinAnswerStmt($Fragebogen, $Kurs);
        if ($minAnswer == null ){
         // header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
          }
  //      $maxAnswer = $this->maxAnswer;
        $maxAnswer = $this->getMaxAnswerStmt($Fragebogen, $Kurs);
        if ($maxAnswer == null ){
        //  header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
          }
   //     $standDev = $this->standDev;
        $standDevArray = $this->getStandDevArrayStmt($Fragebogen, $Kurs);
        if ($standDevArray == null ){
        //  header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
              }
        elseif ($standDevArray !== null ){
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
                $antworten[$i];
            
                $num_elem = count($antworten[$i]);
                $abweichung = 0.0;
                $avg = array_sum($antworten[$i])/$num_elem;
                foreach($antworten[$i] as $j){
                    $abweichung += pow(($j - $avg), 2);
                }
                $standDev = (float)sqrt($abweichung/$num_elem);
/*              echo $fragenummern[$i];
                echo ": ";
                echo $standDev;
                echo "<br> "; */
            }
        }


        $auswertung = array($avgAnswer, $minAnswer, $maxAnswer, $standDev);

      return $auswertung;

        
    
}
}