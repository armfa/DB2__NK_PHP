<?php

include_once 'classes/dbh.class.php';

class Test extends dbh{
    public function getStandDevArrayStmt($Fragebogen, $Kurs){

        // DB Abfrage
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

    $TestObj = new Test; 
    $Fragebogen = "36";
    $Kurs = "wwi118";
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
        $antworten[$i];
    
        $num_elem = count($antworten[$i]);
        $abweichung = 0.0;
        $avg = array_sum($antworten[$i])/$num_elem;
        foreach($antworten[$i] as $j){
            $abweichung += pow(($j - $avg), 2);
        }
        $standDev = (float)sqrt($abweichung/$num_elem);
        echo $fragenummern[$i];
        echo ": ";
        echo $standDev;
        echo "<br> ";
    }

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