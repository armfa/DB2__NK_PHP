<?php


class Fragebogen extends Dbh {

    protected function getFragebogenStmt($titelFragebogen){
        try{
            $sql = "SELECT * FROM fragebogen";
            $stmt = $this->connect()->query($sql);
            $stmt->execute([$titelFragebogen]);
            $fragebogen = $stmt->fetch;
            return $fragebogen;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function checkObFragebogenExistiert($titelFragebogen)
    {
        try {
            $sql = "SELECT * from fragebogen Where Titel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$titelFragebogen]);
            $fragebogen = $stmt->fetch(PDO::FETCH_ASSOC);
            return $fragebogen;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function getInhaltFrage($inhaltFrage){
        try{
            $sql = "SELECT InhaltFrage FROM frage where Titel = ?";
            $stmt = $this->connect()->query($sql);
            $frage = $stmt->fetch();
            return $frage;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function getKuerzelVonFragebogen($titelFragebogen){
        try{
            $sql = "SELECT Kuerzel FROM fragebogen where Titel = ?";
            $stmt = $this->connect()->query($sql);
            $kuerzel = $stmt->fetch();
            return $kuerzel;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function getKuerzelVonFrage($inhaltFrage){
        try{
            $sql = "SELECT Kuerzel FROM frage where InhaltFrage = ?";
            $stmt = $this->connect()->query($sql);
            $kuerzel = $stmt->fetch();
            return $kuerzel;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function getFragebogenVonBenutzerStmt($benutzer){
        try{
            $sql = "SELECT fr.* FROM fragebogen fr, benutzer b WHERE fr.Benutzername = b.Benutzername AND b.Benutzername = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$benutzer]);
            $fragebogen = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $fragebogen;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function setFragebogenStmt($fragebogen, $benutzername){
        try{
            $sql = "INSERT INTO fragebogen (Titel, Benutzername) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$fragebogen, $benutzername]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function deleteFragebogenStmt($fragebogen){
        try{
            $sql = "DELETE FROM fragebogen WHERE Titel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$fragebogen]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }        
    }

    protected function getFragenVonFragebogenStmt($kuerzel){
        try{
            $sql = "SELECT fra.* FROM fragen fra, fragebogen fr WHERE fra.Kuerzel = fr.Kuerzel and fr.Kuerzel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzel]);
            $fragen = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $fragen;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function checkObFrageExistiert($inhaltFrage, $kuerzel){
        try {
            $sql = "SELECT * from fragen Where InhaltFrage = $inhaltFrage and Kuerzel = $kuerzel";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$inhaltFrage]);
            $frage = $stmt->fetch(PDO::FETCH_ASSOC);
            return $frage;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function setFrageStmt($inhaltFrage, $kuerzel){
        try{
            $sql = "INSERT INTO fragen (InhaltFrage, Kuerzel) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$inhaltFrage, $kuerzel]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function deleteFrageStmt($fragenummer){
        try{
            $sql = "DELETE FROM fragen WHERE Fragenummer = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$fragenummer]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function checkObFreischaltungExistiert($kuerzel, $kursname){
        try {
            $sql = "SELECT * from freischalten Where Kuerzel = $kuerzel and Kursname = $kursname";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzel, $kursname]);
            $freigabe = $stmt->fetch(PDO::FETCH_ASSOC);
            return $freigabe;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }
    
    protected function setFreischaltungStmt($kuerzel, $kursname){
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