<?php

class Befragung extends Dbh{

    protected function getFragebogenfromBenutzer($benutzer){
        try {
            $sql = "SELECT * FROM fragebogen"; //ToDo: Nur für benutzer freigfeschaltete Fragebögen
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$benutzer]);
            $Frageboegen = $stmt->fetch(PDO::FETCH_ASSOC);
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

    protected function getFrageAntwortStmt($Fragebogenkuerzel, $Fragenummer, $Student){

    }








}