<?php
//Fabrice Armbruster

//______________________KLASSENBESCHREIBUNG______________________
//Diese Klasse beinhaltet alle Datenbankabfragen, im Zusammenhang mit der Befragung stehen: 

class Befragung extends Dbh{

    public function getFragebogenfromStudentAbgabestatusStnmt($Matrikelnummer, $Abgabestatus){
        try {
            $sql = "SELECT DISTINCT frageb.Kuerzel, frageb.Titel 
            FROM fragebogen frageb, freischalten freisch, kurs k, student s, fragen f, bearbeitet bearb, beantwortet beantw 
            WHERE frageb.Kuerzel = freisch.Kuerzel 
            AND freisch.Kursname = k.Kursname 
            AND k.Kursname = s.Kursname 
            AND s.Matrikelnummer = bearb.Matrikelnummer 
            AND bearb.Kuerzel = frageb.Kuerzel 
            AND s.Matrikelnummer = ? 
            AND bearb.Abgabestatus = ?";
            // Freischalten --> Fragebogen, die für user freigeschaltet sind, aber nicht nicht abgegeben
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Matrikelnummer, $Abgabestatus]);
            $Frageboegen = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $Frageboegen;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

    public function getFragebogenfromStudent($Matrikelnummer){
        try {
            $sql = "SELECT frageb.Kuerzel, frageb.Titel 
            FROM fragebogen frageb, freischalten freisch, kurs k, student s
            WHERE frageb.Kuerzel = freisch.Kuerzel 
            AND freisch.Kursname = k.Kursname 
            AND k.Kursname = s.Kursname 
            AND s.Matrikelnummer = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Matrikelnummer]);
            $Frageboegen = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $Frageboegen;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

    public function setFrageAntwortStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort){
        try {
            $sql = "INSERT INTO beantwortet (Fragenummer, Kuerzel, Matrikelnummer, Antwort) VALUES (?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort]);
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

    public function setFrageAntwortUpdateStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort){
        try {
            $sql = "UPDATE beantwortet SET Antwort = ? where Kuerzel = ? AND Matrikelnummer = ? AND Fragenummer = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Antwort, $Fragebogenkuerzel, $Matrikelnummer, $Fragenummer]);
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

    public function getSingleAntwort($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer){
        try {
            $sql = "SELECT * FROM beantwortet WHERE Matrikelnummer = ? AND KUERZEL = ? and Fragenummer = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Matrikelnummer, $Fragebogenkuerzel, $Fragenummer]);
            $antwortarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $antwortarray;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

    public function getSingleKommentar($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus){
        try {
            $sql = "SELECT * FROM bearbeitet WHERE Matrikelnummer = ? AND KUERZEL = ? and Abgabestatus = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Matrikelnummer, $Fragebogenkuerzel, $Abgabestatus]);
            $beantwortetarray = $stmt->fetch(PDO::FETCH_ASSOC);
            return $beantwortetarray;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

    public function setKommentarUpdateStmt($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus, $kommentar){
        try {
            $sql = "UPDATE bearbeitet SET Kommentar = ?, Abgabestatus = ? where Kuerzel = ? AND Matrikelnummer = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kommentar, $Abgabestatus, $Fragebogenkuerzel, $Matrikelnummer]);
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

    public function setKommentarStmt($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus, $kommentar){
        try {
            $sql = "INSERT INTO bearbeitet (Kuerzel, Matrikelnummer, Abgabestatus, Kommentar) VALUES (?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus, $kommentar]);
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

    public function getFragenummerStmt($Fragebogenkuerzel, $InhaltFrage){
        try {
            $sql = "SELECT * FROM fragen WHERE Kuerzel = ? AND InhaltFrage = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragebogenkuerzel, $InhaltFrage]);
            $frageNummer = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $frageNummer;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }


    public function getFragenStmt($Fragebogenkuerzel){
        try {
            $sql = "SELECT * FROM fragen WHERE Kuerzel = ? ORDER BY Fragenummer";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragebogenkuerzel]);
            $fragenarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $fragenarray;
        } catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
    }

    public function getAnzahlFragenFragebogenStmt($Fragebogenkuerzel){
        try {
            $sql = "SELECT COUNT(Kuerzel) FROM fragen WHERE Kuerzel = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Fragebogenkuerzel]);
            $anzahlFragen = $stmt->fetch(PDO::FETCH_NUM);
            return $anzahlFragen;
        } catch (PDOException $e) {
        header("Location: ../DB2__NK_PHP/indexFehler.php");
        }
}

public function getFrageAntwortStmt($Fragebogenkuerzel, $Matrikelnummer){
    try {
        $sql = "SELECT * FROM beantwortet WHERE Matrikelnummer = ? AND KUERZEL = ? ORDER BY Fragenummer";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$Matrikelnummer, $Fragebogenkuerzel]);
        $antwortarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $antwortarray;
    } catch (PDOException $e) {
        header("Location: ../DB2__NK_PHP/indexFehler.php");
    }
}

public function getFragebogenTitelStmt($Fragebogenkuerzel){
    try {
        $sql = "SELECT * FROM fragebogen WHERE Kuerzel = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$Fragebogenkuerzel]);
        $anzahlFragen = $stmt->fetch(PDO::FETCH_ASSOC);
        return $anzahlFragen;
    } catch (PDOException $e) {
        header("Location: ../DB2__NK_PHP/indexFehler.php");
    }
}

}