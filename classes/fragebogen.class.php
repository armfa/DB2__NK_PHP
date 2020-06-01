<?php
// Isabelle Scheffler

// Diese Klasse beinhaltet alle Funktionen bezüglich des "Fragebogens" und der "Fragen".
// Hierzu zählen die Funktionen
// - showFragebogenVonBenutzer() --> Gibt die Fragebögen des Benutzers in einem Drop-Down Menü aus.
// - checkObFragebogenExistiert() --> Gibt zurück, ob der Titel bereits vergeben ist.
// - setFragebogen() --> Fügt einen Fragebogen in die DB ein.
// - getKuerzelVonFragebogen() --> Gibt das Kuerzel von einem Fragebogen zurück.
// - getFragebogenVonBenutzer() --> Gibt ein Array mit Fragebögen des ausgewählten Benutzers zurück.
// - checkObFragebogenInBefragung() --> Gibt zurück, ob der Fragebogen bereits Teil einer Umfrage ist.
// - deleteFragebogen() --> Löscht den ausgewählten Fragebogen in der DB. 
// - checkObFrageExistiert() --> Gibt zurück, ob der Inhalt der Frage bereits vergeben ist.
// - setFrage() --> Fügt eine Frage in die DB ein.
// - getFragenVonFragebogen() --> Gibt ein Array mit Fragen des ausgewählten Fragebogens zurück.
// - deleteFrage() --> Löscht die ausgewählte Frage in der DB. 
// - checkObFreischaltungExistiert() --> Gibt zurück, ob der Fragebogen bereits dem Kurs freigegeben ist.
// - setFreischaltung() --> Fügt einen Kurs und einen Fragebogen in die Tabelle freischalten in der DB ein.


class Fragebogen extends Dbh
{

    public function showFragebogenVonBenutzer($benutzername){
        try {
            $titelArray = $this->getFragebogenVonBenutzer($benutzername);
            $i = 0;
            while ($i < count($titelArray)) {
                echo "<option value='" . $titelArray[$i]['Kuerzel'] . "'>" . $titelArray[$i]['Titel'] . "</option>";
                $i++;
            }
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }

    public function checkObFragebogenExistiert($titelFragebogen){
        try {
            $sql = "SELECT Titel from fragebogen Where Titel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$titelFragebogen]);
            $fragebogenExistiert = $stmt->fetch(PDO::FETCH_ASSOC);
            return $fragebogenExistiert;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }

    public function setFragebogen($fragebogen, $benutzername){
        try {
            $sql = "INSERT INTO fragebogen (Titel, Benutzername) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$fragebogen, $benutzername]);
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }

    public function getKuerzelVonFragebogen($titelFragebogen){
        try {
            $sql = "SELECT Kuerzel FROM fragebogen where Titel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$titelFragebogen]);
            $kuerzel = $stmt->fetch(PDO::FETCH_ASSOC)['Kuerzel'];
            return $kuerzel;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }

    public function getFragebogenVonBenutzer($benutzername){
        try {
            $sql = "SELECT fr.* FROM fragebogen fr, benutzer b WHERE fr.Benutzername = b.Benutzername AND b.Benutzername = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$benutzername]);
            $fragebogenArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $fragebogenArray;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }


    public function deleteFragebogen($kuerzel){
        try {
            $sql = "DELETE FROM fragebogen WHERE Kuerzel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzel]);
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }

    public function checkObFrageExistiert($inhaltFrage, $kuerzel){
        try {
            $sql = "SELECT Fragenummer from fragen Where InhaltFrage = ? and Kuerzel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$inhaltFrage, $kuerzel]);
            $frage = $stmt->fetch(PDO::FETCH_ASSOC);
            return $frage;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }

    public function setFrage($inhaltFrage, $kuerzel){
        try {
            $sql = "INSERT INTO fragen (InhaltFrage, Kuerzel) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$inhaltFrage, $kuerzel]);
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }

    public function getFragenVonFragebogen($kuerzel){
        try {
            $sql = "SELECT fra.* FROM fragen fra, fragebogen fr WHERE fra.Kuerzel = fr.Kuerzel and fr.Kuerzel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzel]);
            $fragenArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $fragenArray;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }

    public function deleteFrage($fragenummer){
        try {
            $sql = "DELETE FROM fragen WHERE Fragenummer = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$fragenummer]);
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }

    public function checkObFreischaltungExistiert($kuerzel, $kursname){
        try {
            $sql = "SELECT Kuerzel from freischalten Where Kuerzel = ? and Kursname = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzel, $kursname]);
            $freigabe = $stmt->fetch(PDO::FETCH_ASSOC);
            return $freigabe;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }

    public function setFreischaltung($kuerzel, $kursname){
        try {
            $sql = "INSERT INTO freischalten (Kuerzel, Kursname) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzel, $kursname]);
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }

    public function checkObFragebogenInBefragung($kuerzelFragebogen) {
        try {
            $sql = "SELECT Kuerzel from bearbeitet Where Kuerzel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kuerzelFragebogen]);
            $fragebogenInBearbeitung = $stmt->fetch(PDO::FETCH_ASSOC);
            return $fragebogenInBearbeitung;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
            exit();
        }
    }
}
