<?php
//Isabelle Scheffler
//14.04.2020

    //ToDo: Error Handling is missing 


class Fragebogen extends Dbh {

    protected function getTitelFragebogen($titelFragebogen){
        $sql = "SELECT Titel FROM fragebogen where Titel = ?";
        $stmt = $this->connect()->query($sql);
        $titel = $stmt->fetch();
        return $titel;
    }

    protected function getInhaltFrage($inhaltFrage){
        $sql = "SELECT InhaltFrage FROM frage where Titel = ?";
        $stmt = $this->connect()->query($sql);
        $frage = $stmt->fetch();
        return $frage;
    }

    protected function getKuerzelVonFrage($inhaltFrage){
        $sql = "SELECT Kuerzel FROM frage where InhaltFrage = ?";
        $stmt = $this->connect()->query($sql);
        $kuerzel = $stmt->fetch();
        return $kuerzel;
    }

    protected function getFragebogenVonBenutzerStmt($benutzer){
        $sql = "SELECT fr.* FROM fragebogen fr, benutzer b WHERE fr.Benutzername = b.Benutzername AND b.Benutzername = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$benutzer]);
        $fragebogen = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fragebogen;
    }

    protected function setFragebogenStmt($fragebogen, $benutzername){
        $sql = "INSERT INTO fragebogen (Titel, Benutzername) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$fragebogen, $benutzername]);
    }

    protected function deleteFragebogenStmt($fragebogen){
        $sql = "DELETE FROM fragebogen WHERE Titel = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$fragebogen]);
    }

    protected function getFragenVonFragebogenStmt($fragebogen){
        $sql = "SELECT * FROM fragen WHERE Kuerzel = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$fragebogen]);
        $fragen = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $fragen;
    }

    protected function setFrageStmt($inhaltFrage, $Kuerzel){
        $sql = "INSERT INTO fragen (InhaltFrage, Kuerzel) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$inhaltFrage, $Kuerzel]);
    }

    protected function deleteFrageStmt($fragenummer){
        $sql = "DELETE FROM fragen WHERE Fragenummer = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$fragenummer]);
    }
}