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
                AND s.kurs = ?
                GROUP BY s.kurs";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogen, $Kurs]);
                $kommentarArray = $stmt->fetch(PDO::FETCH_ASSOC); 

                foreach($kommentarArray as $zeile) {
                //Zeilenumbruch zu nach jedem Kommentar
                echo '<br>';
                echo '<br>' . $zeile['Kommentar'];
                return $kommentarArray;
                }
            } catch (PDOException $e) {
                header("Location: ../DB2__NK_PHP/indexFehler.php");
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
                AND s.kurs = ?
                GROUP BY s.kurs";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogen, $Kurs]);
                $avgAnswer = $stmt->fetch(PDO::FETCH_ASSOC); 
 //               return $ergebnis;
                return $avgAnswer;
            } catch (PDOException $e) {
                header("Location: ../DB2__NK_PHP/indexFehler.php");
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
                AND s.kurs = ?
                GROUP BY s.kurs";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogen, $Kurs]);
                $minAnswer = $stmt->fetch(PDO::FETCH_ASSOC); 
               // return $ergebnis;
               return $minAnswer;
            } catch (PDOException $e) {
                header("Location: ../DB2__NK_PHP/indexFehler.php");
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
                AND s.kurs = ?
                GROUP BY s.kurs";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogen, $Kurs]);
                $maxAnswer = $stmt->fetch(PDO::FETCH_ASSOC);
                return $maxAnswer;
            } catch (PDOException $e) {
                header("Location: ../DB2__NK_PHP/indexFehler.php");
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
                AND s.kurs = ?
                GROUP BY s.kurs";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogen, $Kurs]);
                $standDev = $stmt->fetch(PDO::FETCH_ASSOC); 
// Berechnung der Standardabweichung hier: 
                $num = count($standDev);
                $avg = array_sum($standDev) / $num;
                $abweichung = 0;
                foreach ($standDev as $elem) {
                    $abweichung += ($elem - $avg) * ($elem - $avg);
                }
                $standDev = sqrt( (1/($num-1)) * $abweichung);
                return $standDev;
            } catch (PDOException $e) {
                header("Location: ../DB2__NK_PHP/indexFehler.php");
            }
        }
    }

}
