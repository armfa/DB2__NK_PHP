<?php
//Dana Gessler 30.04.2020
// Klasse zur Ergebnisauswertung
//Diese Klasse wertet Fragebögen aus. Die Auswertung erfolgt nach Auswahl von auszuwertendem Fragebogen und ausgewähltem Kurs.
//Kommentare und Auswertungen beziehen sich auf den ausgewählten Kurs.


class Ergebnis extends dbh{

//   NOT TESTED YET
    // Kommentare je Fragebogen & Kurs abfragen, Ausgabe erfolgt kurseweise mit Zeilenumbruch zwischen jedem Kommentar
    protected function getKommentareStmt($Fragebogen , $Kurs){
        {
            try {
                $sql = "SELECT Kommentar 
                FROM        bearbeitet bear,    
                            beantwortet bean, 
                            student s                
                WHERE   bear.Matrikelnummer = s.Matrikelnummer  
                AND bear.Matrikelnummer = bean.Matrikelnummer  
                AND s.Matrikelnummer = bean.Matrikelnummer  
                AND bear.Abgabestatus = 1
                AND bean.Fragenummer = bear.Kuerzel
                AND bear.Kuerzel = ?
                AND s.kursname = ?
                GROUP BY s.kursname";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogen, $Kurs]);
                $kommentarArray = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($kommentarArray == null ){
                    header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noComments");
                }
                else{
                $ausgabe = implode("<br>\n",$kommentarArray);
                echo $ausgabe;
                return $kommentarArray;
                }}
             catch (PDOException $e) {
            //    header("Location: ../DB2__NK_PHP/indexFehler.php");
            echo $e; 
            }
        }
    }

//   NOT TESTED YET
    //Antworten je Fragebogen & Kurs abfragen, Berechnung der durchnittlichen Antwort. 

    protected function getAvgAnswerStmt($Fragebogen, $Kurs){
        {
            try {
                $sql = "SELECT avg(Antwort) 
                FROM        bearbeitet bear,    
                            beantwortet bean, 
                            student s 
                WHERE   bear.Matrikelnummer = s.Matrikelnummer  
                AND bear.Matrikelnummer = bean.Matrikelnummer  
                AND s.Matrikelnummer = bean.Matrikelnummer  
                AND bear.Abgabestatus = 1
                AND bean.Fragenummer = bear.Kuerzel
                AND bear.Kuerzel = ?
                AND s.kursname = ?
                GROUP BY s.kursname";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogen, $Kurs]);
                $avgAnswer = $stmt->fetch(PDO::FETCH_ASSOC); 
 //               return $ergebnis;

 
                if ($avgAnswer == null ){
                header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
                }
                    else{
                return $avgAnswer;}
            } catch (PDOException $e) {
            //    header("Location: ../DB2__NK_PHP/indexFehler.php");
            echo $e; 
            }
        }
    }

    //   NOT TESTED YET
    //Antworten je Fragebogen & Kurs abfragen, Berechnung der minimalen Antwort. 
    protected function getMinAnswerStmt($Fragebogen, $Kurs){
        {
            try {
                $sql = "SELECT min(bean.Antwort) 
                FROM        bearbeitet bear,    
                            beantwortet bean, 
                            student s 
                WHERE   bear.Matrikelnummer = s.Matrikelnummer  
                AND bear.Matrikelnummer = bean.Matrikelnummer  
                AND s.Matrikelnummer = bean.Matrikelnummer  
                AND bear.Abgabestatus = 1
                AND bean.Fragenummer = bear.Kuerzel
                AND bear.Kuerzel = ?
                AND s.kursname = ?
                GROUP BY s.kursname";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogen, $Kurs]);
                $minAnswer = $stmt->fetch(PDO::FETCH_ASSOC); 
               // return $ergebnis;
 
               if ($minAnswer == null ){
                header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
                }
                    else{
                return $minAnswer;}
            } catch (PDOException $e) {
            //    header("Location: ../DB2__NK_PHP/indexFehler.php");
            echo $e; 
            }
        }
    }
    //   NOT TESTED YET
    //Antworten je Fragebogen & Kurs abfragen, Berechnung der maximalen Antwort. 

    protected function getMaxAnswerStmt($Fragebogen, $Kurs){
        {
            try {
                $sql = "SELECT max(bean.Antwort) 
                FROM        bearbeitet bear,    
                            beantwortet bean, 
                            student s 
                WHERE   bear.Matrikelnummer = s.Matrikelnummer  
                AND bear.Matrikelnummer = bean.Matrikelnummer  
                AND s.Matrikelnummer = bean.Matrikelnummer  
                AND bear.Abgabestatus = 1
                AND bean.Fragenummer = bear.Kuerzel
                AND bear.Kuerzel = ?
                AND s.kursname = ?
                GROUP BY s.kursname";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogen, $Kurs]);
                $maxAnswer = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($maxAnswer == null ){
                    header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
                    }
                        else{
                    return $maxAnswer;}
                } catch (PDOException $e) {
                //    header("Location: ../DB2__NK_PHP/indexFehler.php");
                echo $e; 
                }
            }
        }

//   NOT TESTED YET
    //Antworten je Fragebogen & Kurs abfragen, Berechnung der Standardabweichung der Antworten. 

    protected function getStandDevStmt($Fragebogen, $Kurs){
        {
            try {
                $sql = "SELECT bean.Antwort
                FROM        bearbeitet bear,    
                            beantwortet bean, 
                            student s 
                WHERE   bear.Matrikelnummer = s.Matrikelnummer  
                AND bear.Matrikelnummer = bean.Matrikelnummer  
                AND s.Matrikelnummer = bean.Matrikelnummer  
                AND bear.Abgabestatus = 1
                AND bean.Fragenummer = bear.Kuerzel
                AND bear.Kuerzel = ?
                AND s.kursname = ?
                GROUP BY s.kursname";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogen, $Kurs]);
                $standDev = $stmt->fetch(PDO::FETCH_ASSOC); 
// Berechnung der Standardabweichung hier: 

        if ($standDev == null ){
                 header("Location: ../DB2__NK_PHP/indexErgebnis.php?fehler=noValues");
                     }
             else{
            $num_elem = count($standDev);
            $abweichung = 0.0;

            $avg = array_sum($standDev)/$num_elem;
            foreach($standDev as $i){
            $abweichung += pow(($i - $avg), 2);
                }

                $standDev = (float)sqrt($abweichung/$num_elem);
             return $standDev;}
        } catch (PDOException $e) {
        //    header("Location: ../DB2__NK_PHP/indexFehler.php");
                echo $e; 
            }
        }
    }
}