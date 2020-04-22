<?php

class Befragung extends Dbh{

    protected function getFragebogenfromBenutzer($benutzer){
        try {
            $sql = "SELECT * FROM fragebogen WHERE Benutzername = ?"; //ToDo: Nur für benutzer freigfeschaltete Fragebögen
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$benutzer]);
            $Frageboegen = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $Frageboegen;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function getAnzahlFragenFragebogenStmt($Fragebogenkuerzel){
            try {
                $sql = "SELECT COUNT(Kuerzel) FROM fragen WHERE Kuerzel = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$Fragebogenkuerzel]);
                $anzahlFragen = $stmt->fetch(PDO::FETCH_NUM);
                return $anzahlFragen;
            } catch (PDOException $e) {
                $exceptionMessage = new exceptionMessage();
                $exceptionMessage->displayException($e);
            }
    }

    protected function getFragebogenTitelStmt($Fragebogenkuerzel){
        try {
            $sql = "SELECT * FROM fragebogen WHERE Kuerzel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragebogenkuerzel]);
            $anzahlFragen = $stmt->fetch(PDO::FETCH_ASSOC);
            return $anzahlFragen;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function getFragenStmt($Fragebogenkuerzel){
        try {
            $sql = "SELECT * FROM fragen WHERE Kuerzel = ? ORDER BY Fragenummer";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragebogenkuerzel]);
            $fragenarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $fragenarray;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function setFrageAntwortStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort){
        try {
            $sql = "INSERT INTO beantwortet (Fragenummer, Kuerzel, Matrikelnummer, Antwort) VALUES (?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function getFrageAntwortStmt($Fragebogenkuerzel, $Matrikelnummer){
        try {
            $sql = "SELECT * FROM beantwortet WHERE Matrikelnummer = ? AND KUERZEL = ? ORDER BY Fragenummer";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Matrikelnummer, $Fragebogenkuerzel]);
            $antwortarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $antwortarray;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function setFrageAntwortUpdateStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort){
        try {
            $sql = "UPDATE beantwortet SET Antwort = ? where Kuerzel = ? AND Matrikelnummer = ? AND Fragenummer = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Antwort, $Fragebogenkuerzel, $Matrikelnummer, $Fragenummer]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function getSingleAntwort($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer){
        try {
            $sql = "SELECT * FROM beantwortet WHERE Matrikelnummer = ? AND KUERZEL = ? and Fragenummer = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Matrikelnummer, $Fragebogenkuerzel, $Fragenummer]);
            $antwortarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $antwortarray;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function getSingleKommentar($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus){
        try {
            $sql = "SELECT * FROM bearbeitet WHERE Matrikelnummer = ? AND KUERZEL = ? and Abgabestatus = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Matrikelnummer, $Fragebogenkuerzel, $Abgabestatus]);
            $beantwortetarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $beantwortetarray;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function setKommentarUpdateStmt($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus, $kommentar){
        try {
            $sql = "UPDATE bearbeitet SET Kommentar = ? AND Abgabestatus = ? where Kuerzel = ? AND Matrikelnummer = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kommentar, $Abgabestatus, $Fragebogenkuerzel, $Matrikelnummer]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function setKommentarStmt($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus, $kommentar){
        try {
            $sql = "INSERT INTO bearbeitet (Kuerzel, Matrikelnummer, Abgabestatus, Kommentar) VALUES (?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus, $kommentar]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }
}