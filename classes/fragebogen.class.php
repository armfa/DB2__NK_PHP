<?php
//Isabelle Scheffler

    //ToDo: Error Handling is missing 

class Fragebogen extends Dbh {

    public function checkObFragebogenExistiert($titelFragebogen) {
        try {
            $sql = "SELECT * from fragebogen Where Titel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$titelFragebogen]);
            $fragebogenExistiert = $stmt->fetch(PDO::FETCH_ASSOC);
            return $fragebogenExistiert;
        } catch (PDOException $e) {
            $GLOBALS["exception"]->displayException($e);
        }
    }

    public function getKuerzelVonFragebogen($titelFragebogen){
        try{
            $sql = "SELECT Kuerzel FROM fragebogen where Titel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$titelFragebogen]);
            $kuerzel = $stmt->fetch(PDO::FETCH_ASSOC);
            return $kuerzel;
        } catch (PDOException $e) {
            $GLOBALS["exception"]->displayException($e);
        }
    }

    public function getKuerzelVonFrage($inhaltFrage){
        try{
            $sql = "SELECT Kuerzel FROM frage where InhaltFrage = ?";
            $stmt = $this->connect()->query($sql);
            $kuerzel = $stmt->fetch();
            return $kuerzel;
        } catch (PDOException $e) {
            $GLOBALS["exception"]->displayException($e);
        }
    }

    public function getFragebogenVonBenutzer($benutzer){
        try{
            $sql = "SELECT fr.* FROM fragebogen fr, benutzer b WHERE fr.Benutzername = b.Benutzername AND b.Benutzername = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$benutzer]);
            $fragebogenArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $fragebogenArray;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    public function setFragebogen($fragebogen, $benutzername){
        try{
            $sql = "INSERT INTO fragebogen (Titel, Benutzername) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$fragebogen, $benutzername]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    public function deleteFragebogen($kuerzel){
        try{
            $sql = "DELETE FROM fragebogen WHERE Kuerzel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzel]);
        } catch (PDOException $e) {
            $GLOBALS["exception"]->displayException($e);
        }        
    }

    public function getFragenVonFragebogen($kuerzel){
        try{
            $sql = "SELECT fra.* FROM fragen fra, fragebogen fr WHERE fra.Kuerzel = fr.Kuerzel and fr.Kuerzel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzel]);
            $fragenArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $fragenArray;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    public function checkObFrageExistiert($inhaltFrage, $kuerzel){
        try {
            $sql = "SELECT * from fragen Where InhaltFrage = ? and Kuerzel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$inhaltFrage,$kuerzel]);
            $frage = $stmt->fetch(PDO::FETCH_ASSOC);
            return $frage;
        } catch (PDOException $e) {
            $GLOBALS["exception"]->displayException($e);
        }
    }

    public function setFrage($inhaltFrage, $kuerzel){
        try{
            $sql = "INSERT INTO fragen (InhaltFrage, Kuerzel) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$inhaltFrage, $kuerzel]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    public function deleteFrage($fragenummer){
        try{
            $sql = "DELETE FROM fragen WHERE Fragenummer = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$fragenummer]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    public function checkObFreischaltungExistiert($kuerzel, $kursname){
        try {
            $sql = "SELECT * from freischalten Where Kuerzel = ? and Kursname = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzel, $kursname]);
            $freigabe = $stmt->fetch(PDO::FETCH_ASSOC);
            return $freigabe;
        } catch (PDOException $e) {
            $GLOBALS["exception"]->displayException($e);
        }
    }
    
    public function setFreischaltung($kuerzel, $kursname){
        try{
            $sql = "INSERT INTO freischalten (Kuerzel, Kursname) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzel, $kursname]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }
}