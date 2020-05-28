<?php
//Dana Gessler 11.05.2020

//______________________KLASSENBESCHREIBUNG______________________
//Diese Klasse fragt die benötigten Werte zur Auswertung der Fragebögen aus der Datenbank ab. 
// getKommentareStmt() --> fragt alle abgegebenen Kommentare aus der Tabelle "bearbeitet" je Fragebogen je Kurs ab
// getAvgAnswerStmt() --> durchschnittliche Antworten je Fragebogen, je Frage, je Kurs abfragen
// getInhaltFrage() -->  Funktion zur Abfrage des Frageinhalts anhand des Kürzels
// getMinAnswerStmt() --> minimale Antworten je Fragebogen, je Frage, je Kurs abfragen
// getMaxAnswerStmt() --> maximale Antworten je Fragebogen, je Frage, je Kurs abfragen
// getStandDevArrayStmt() --> Selektion der Werte zur späteren Berechnung der Standardabweichung

class Ergebnis extends dbh
{
    protected function getKommentareStmt($Fragebogen, $Kurs)
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
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

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
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

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
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }


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
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

    protected function getMaxAnswerStmt($Fragebogen, $Kurs)
    {
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
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

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
            //Array für die Werte, die zur Berechnung der Standardabweichung gebraucht werden
            $valueForStandDev = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $valueForStandDev;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }
}
