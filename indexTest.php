<?php

include_once 'classes/dbh.class.php';


$Fragebogen = "36";
$Kurs = "wwi118";

class Test extends dbh{



        function getKommentareStmt($Fragebogen , $Kurs){
            $sql = "SELECT bear.Kommentar 
            FROM        bearbeitet bear,    
                        student s                
            WHERE   bear.Matrikelnummer = s.Matrikelnummer  
            AND bear.Abgabestatus = 1
            AND bear.Kuerzel = ?
            AND s.Kursname = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragebogen, $Kurs]);
            $kommentarArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $kommentarArray;
        }



        
        function showKommentare($Fragebogen, $Kurs){
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
                echo $kommentarString;
            }
        }
    
}

$TestObj = new Test; 

$TestObj->showKommentare($Fragebogen, $Kurs);


        /* 
        // DB Abfrage

          public function getStandDevArrayStmt($Fragebogen, $Kurs){
$sql = "SELECT bean.Fragenummer, bean.Antwort
FROM        bearbeitet bear,    
            beantwortet bean, 
            student s 
WHERE   bear.Matrikelnummer = s.Matrikelnummer  
AND bear.Matrikelnummer = bean.Matrikelnummer  
AND s.Matrikelnummer = bean.Matrikelnummer  
AND bear.Abgabestatus = 1
AND bean.Kuerzel = bear.Kuerzel
AND bear.Kuerzel = ?
AND s.Kursname = ?
ORDER BY bean.Kuerzel";
$stmt = $this->connect()->prepare($sql);
$stmt->execute([$Fragebogen, $Kurs]);
$standDevArray = $stmt->fetchAll(PDO::FETCH_ASSOC); 


return $standDevArray;
    }}

   
    //Befüllen des Arrays
    $standDevArray = $TestObj->getStandDevArrayStmt($Fragebogen, $Kurs);
    
    $fragenummern = array();
    $antworten = array(array());

    //Fragenummern suchen
    foreach ($standDevArray as $row){
        if( !in_array($row['Fragenummer'], $fragenummern)){ 
            array_push($fragenummern,$row['Fragenummer'] );
        }
    }

    $index;
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
        echo $fragenummern[$i];
        echo ": ";
        echo $standDev;
        echo "<br> ";
    } */

    //echo count($antworten);
    //arrayx = [[1,2,3],[1,2,3]]
    //arrayx[1] = [1,2,3]


    //19 => 0,82
    //20 => 0,14

/*     if ($standDevArray == null ){
        //  header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
    }
    elseif ($standDevArray !== null ){
        $num_elem = count($standDevArray);
        $abweichung = 0.0;
        $avg = array_sum($standDevArray)/$num_elem;
        foreach($standDevArray as $i){
                $abweichung += pow(($i - $avg), 2);
        }
        $standDev = (float)sqrt($abweichung/$num_elem);
    } */







    //foreach ($array as $row) {
/*          echo $row['Fragenummer'].".";
        echo $row['Antwort']."<br>"; */
        //$newArray = array($newArray) + $row['Antwort'];
    //}
   

?>