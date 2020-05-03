<?php
//Isabelle Scheffler

    //ToDo: Error Handling is missing 

<<<<<<< HEAD

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
=======
class Fragebogen extends Dbh {

    public function checkObFragebogenExistiert($titelFragebogen) {
>>>>>>> 19786b487eb50a97aff30ecf98cf51f8ae13b414
        try {
            $sql = "SELECT * from fragebogen Where Titel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$titelFragebogen]);
            $fragebogenExistiert = $stmt->fetch(PDO::FETCH_ASSOC);
            return $fragebogenExistiert;
        } catch (PDOException $e) {
<<<<<<< HEAD
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

    protected function getKuerzelVonFrage($inhaltFrage){
=======
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
>>>>>>> 19786b487eb50a97aff30ecf98cf51f8ae13b414
        try{
            $sql = "SELECT Kuerzel FROM frage where InhaltFrage = ?";
            $stmt = $this->connect()->query($sql);
            $kuerzel = $stmt->fetch();
            return $kuerzel;
        } catch (PDOException $e) {
<<<<<<< HEAD
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function getFragebogenVonBenutzerStmt($benutzer){
=======
            $GLOBALS["exception"]->displayException($e);
        }
    }

    public function getFragebogenVonBenutzer($benutzer){
>>>>>>> 19786b487eb50a97aff30ecf98cf51f8ae13b414
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

<<<<<<< HEAD
    protected function setFragebogenStmt($fragebogen, $benutzername){
=======
    public function setFragebogen($fragebogen, $benutzername){
>>>>>>> 19786b487eb50a97aff30ecf98cf51f8ae13b414
        try{
            $sql = "INSERT INTO fragebogen (Titel, Benutzername) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$fragebogen, $benutzername]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

<<<<<<< HEAD
    protected function deleteFragebogenStmt($fragebogen){
        try{
            $sql = "DELETE FROM fragebogen WHERE Titel = ?";
=======
    public function deleteFragebogen($kuerzel){
        try{
            $sql = "DELETE FROM fragebogen WHERE Kuerzel = ?";
>>>>>>> 19786b487eb50a97aff30ecf98cf51f8ae13b414
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzel]);
        } catch (PDOException $e) {
<<<<<<< HEAD
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }        
    }

    protected function getFragenVonFragebogenStmt($kuerzel){
        try{
            $sql = "SELECT * FROM fragen WHERE Kuerzel = ?";
=======
            $GLOBALS["exception"]->displayException($e);
        }        
    }

    public function getFragenVonFragebogen($kuerzel){
        try{
            $sql = "SELECT fra.* FROM fragen fra, fragebogen fr WHERE fra.Kuerzel = fr.Kuerzel and fr.Kuerzel = ?";
>>>>>>> 19786b487eb50a97aff30ecf98cf51f8ae13b414
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzel]);
            $fragenArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $fragenArray;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

<<<<<<< HEAD
    protected function checkObFrageExistiert($inhaltFrage){
        {
            try {
                $sql = "SELECT * from fragen Where InhaltFrage = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$inhaltFrage]);
                $frage = $stmt->fetch(PDO::FETCH_ASSOC);
                return $frage;
            } catch (PDOException $e) {
                $exceptionMessage = new exceptionMessage();
                $exceptionMessage->displayException($e);
            }
        }
    }

    protected function setFrageStmt($inhaltFrage, $kuerzel){
=======
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
>>>>>>> 19786b487eb50a97aff30ecf98cf51f8ae13b414
        try{
            $sql = "INSERT INTO fragen (InhaltFrage, Kuerzel) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$inhaltFrage, $kuerzel]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

<<<<<<< HEAD
    protected function deleteFrageStmt($fragenummer){
=======
    public function deleteFrage($fragenummer){
>>>>>>> 19786b487eb50a97aff30ecf98cf51f8ae13b414
        try{
            $sql = "DELETE FROM fragen WHERE Fragenummer = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$fragenummer]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

<<<<<<< HEAD
    protected function setFreischaltungStmt($kuerzel, $kursname){
=======
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
>>>>>>> 19786b487eb50a97aff30ecf98cf51f8ae13b414
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