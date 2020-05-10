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
                $sql = "SELECT bear.Kommentar 
                FROM        bearbeitet bear,    
                            student s                
                WHERE   bear.Matrikelnummer = s.Matrikelnummer  
                AND bear.Abgabestatus = 1
                AND bear.Kuerzel = ?
                AND s.kursname = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogen, $Kurs]);
                $kommentarArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $kommentarArray;
                }
                catch (PDOException $e) {
                //    header("Location: ../DB2__NK_PHP/indexFehler.php");
                echo $e; 
            }
        }
    }

//   NOT TESTED YET
    //Antworten je Fragebogen & Kurs abfragen, Berechnung der durchnittlichen Antwort. 

    protected function getAvgAnswerStmt($Fragebogen, $Kurs){
        try {
            $sql = "SELECT bean.Fragenummer, avg(bean.Antwort) 
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
            GROUP BY bean.Fragenummer";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragebogen, $Kurs]);
            $avgAnswers = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $avgAnswers;
        } catch (PDOException $e) {
            // header("Location: ../DB2__NK_PHP/indexFehler.php");
            echo $e; 
        }
    }


    protected function getInhaltFrage($Fragebogen){
        try {
            $sql = "SELECT f.Fragenummer, f.InhaltFrage
            FROM        fragen f, fragebogen fb 
            WHERE f.Kuerzel = fb.Kuerzel
            AND f.Kuerzel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragebogen]);
            $fragenummerInhaltFrage = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $fragenummerInhaltFrage;
        } catch (PDOException $e) {
            //    header("Location: ../DB2__NK_PHP/indexFehler.php");
            echo $e; 
        }
    }
    //   NOT TESTED YET
    //Antworten je Fragebogen & Kurs abfragen, Berechnung der minimalen Antwort. 
    protected function getMinAnswerStmt($Fragebogen, $Kurs){
        try {
            $sql = "SELECT bean.Fragenummer, min(bean.Antwort) 
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
            GROUP BY bean.Fragenummer";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragebogen, $Kurs]);
            $minAnswer = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $minAnswer;
        } catch (PDOException $e) {
            //    header("Location: ../DB2__NK_PHP/indexFehler.php");
            echo $e; 
        }
    }
    //   NOT TESTED YET
    //Antworten je Fragebogen & Kurs abfragen, Berechnung der maximalen Antwort. 

    protected function getMaxAnswerStmt($Fragebogen, $Kurs){
        {
            try {
                $sql = "SELECT bean.Fragenummer, max(bean.Antwort) 
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
                GROUP BY bean.Fragenummer";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogen, $Kurs]);
                $maxAnswer = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $maxAnswer;
                } catch (PDOException $e) {
                //    header("Location: ../DB2__NK_PHP/indexFehler.php");
                echo $e; 
                }
            }
        }

//   NOT TESTED YET
    //Antworten je Fragebogen & Kurs abfragen, Abfrage der Werte für die Berechnung der Standardabweichung der Antworten. 
    protected function getStandDevArrayStmt($Fragebogen, $Kurs){
        try {
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
            AND s.Kursname = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragebogen, $Kurs]);
            //Array für die Werte die zur Berechnung der Standardabweichung gebraucht werden
            $valueForStandDev = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $valueForStandDev;
        } catch (PDOException $e) {
            // header("Location: ../DB2__NK_PHP/indexFehler.php");
            echo $e; 
        }
    }
}