<?php
//Dana Gessler 11.05.2020
// Klasse zur Ergebnisauswertung
//Diese Klasse fragt die benötigten Werte zur Auswertung der Fragebögen aus der Datenbank ab. 


class Ergebnis extends dbh
{


    // Kommentare je Fragebogen & Kurs abfragen, Ausgabe erfolgt kursweise
    protected function getKommentareStmt($Fragebogen, $Kurs)
    { {
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
            } catch (PDOException $e) {
                //    header("Location: ../DB2__NK_PHP/indexFehler.php");
                echo $e;
            }
        }
    }


    //Antworten je Fragebogen & Kurs abfragen, Rückgabe der durchnittlichen Antwort. 

    protected function getAvgAnswerStmt($Fragebogen, $Kurs)
    {
        try {
            $sql = "SELECT bean.Fragenummer, avg(bean.Antwort) 
            FROM        bearbeitet bear,    
                        beantwortet bean, 
                        student s, 
                        fragen f  
            WHERE   bear.Matrikelnummer = s.Matrikelnummer  
            AND bear.Matrikelnummer = bean.Matrikelnummer  
            AND s.Matrikelnummer = bean.Matrikelnummer  
            AND bear.Abgabestatus = 1
            AND bean.Kuerzel = bear.Kuerzel
            AND f.Fragenummer = bean.Fragenummer
            AND f.Kuerzel = bear.Kuerzel
            AND bean.Kuerzel = f.Kuerzel
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

    //Funktion zur Abfrage des Frageinhalts anhand des Kürzels
    protected function getInhaltFrage($Fragebogen)
    {
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

    //Antworten je Fragebogen & Kurs abfragen, Rückgabe der minimalen Antworten. 
    protected function getMinAnswerStmt($Fragebogen, $Kurs)
    {
        try {
            $sql = "SELECT bean.Fragenummer, min(bean.Antwort) 
            FROM        bearbeitet bear,    
                        beantwortet bean, 
                        student s, 
                        fragen f
            WHERE   bear.Matrikelnummer = s.Matrikelnummer  
            AND bear.Matrikelnummer = bean.Matrikelnummer  
            AND s.Matrikelnummer = bean.Matrikelnummer  
            AND bear.Abgabestatus = 1
            AND bean.Kuerzel = bear.Kuerzel
            AND f.Fragenummer = bean.Fragenummer
            AND f.Kuerzel = bear.Kuerzel
            AND bean.Kuerzel = f.Kuerzel
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

    //Antworten je Fragebogen & Kurs abfragen, Rückgabe der maximalen Antworten. 
    protected function getMaxAnswerStmt($Fragebogen, $Kurs)
    { {
            try {
                $sql = "SELECT bean.Fragenummer, max(bean.Antwort) 
                FROM        bearbeitet bear,    
                            beantwortet bean, 
                            student s,
                            fragen f
                WHERE   bear.Matrikelnummer = s.Matrikelnummer  
                AND bear.Matrikelnummer = bean.Matrikelnummer  
                AND s.Matrikelnummer = bean.Matrikelnummer  
                AND bear.Abgabestatus = 1
                AND bean.Kuerzel = bear.Kuerzel
                AND f.Fragenummer = bean.Fragenummer
                AND f.Kuerzel = bear.Kuerzel
                AND bean.Kuerzel = f.Kuerzel
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
    protected function getStandDevArrayStmt($Fragebogen, $Kurs)
    {
        try {
            $sql = "SELECT bean.Fragenummer, bean.Antwort
            FROM        bearbeitet bear,    
                        beantwortet bean, 
                        student s,
                        fragen f 
            WHERE   bear.Matrikelnummer = s.Matrikelnummer  
            AND bear.Matrikelnummer = bean.Matrikelnummer  
            AND s.Matrikelnummer = bean.Matrikelnummer  
            AND bear.Abgabestatus = 1
            AND bean.Kuerzel = bear.Kuerzel
            AND f.Fragenummer = bean.Fragenummer
            AND f.Kuerzel = bear.Kuerzel
            AND bean.Kuerzel = f.Kuerzel
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
