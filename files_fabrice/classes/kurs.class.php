<?php
//Fabrice Armbruster
//13.04.2020

//Diese Klasse beinhaltet alle Funktionen bezüglich des "Kurses".
//Hierzu zählen die Funktionen
// - getKurses() --> returns Array mit Kursen
// - getStudentenVonKurs() -> returns Array mit Studenten eines Kurses
// - setKurs() --> Fügt Kurs in DB hinzu
// - deleteKurs() --> Löscht Kurs in der DB
// - setStudent() --> Fügt Student DB hinzu
// - deleteStudent() --> Löscht Student in der DB 
// - getKuresfromBenutzerStmt() --> returns Array mit Kursen dieses Benutzers

    //ToDo: Error Handling is missing 


class Kurs extends Dbh {

    protected function getKurses(){
        $sql = "SELECT * FROM Kurs";
        $stmt = $this->connect()->query($sql);
        $kurses = $stmt->fetch();
        return $kurses;
    }

    protected function getKuresfromBenutzerStmt($benutzer){
        $sql = "SELECT k.* FROM kurs k,freischalten f, fragebogen fr, benutzer b WHERE k.Kursname = f.Kursname AND f.Kuerzel = fr.Kuerzel AND fr.Benutzername = b.Benutzername AND b.Benutzername = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$benutzer]);
        $kursname = $stmt->fetch(PDO::FETCH_ASSOC);
        return $kursname;
    }

    protected function setKursStmt($Kursname){
        $sql = "INSERT INTO kurs (Kursname) VALUES (?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$Kursname]);
    }

    protected function deleteKursStmt($Kursname){
        $sql = "DELETE FROM kurs WHERE Kursname = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$Kursname]);
    }

    protected function getStudentenVonKursStmt($Kursname){
        $sql = "SELECT * FROM student WHERE Kursname = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$Kursname]);
        $student = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $student;
    }

    protected function setStudentStmt($Matrikelnummer, $Studentenname, $Kursname){
        $sql = "INSERT INTO student (Matrikelnummer, Studentenname, Kursname) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$Matrikelnummer, $Studentenname, $Kursname, ]);
    }

    protected function deleteStudentStmt($Matrikelnummer){
        $sql = "DELETE FROM student WHERE Matrikelnummer = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$Matrikelnummer]);
    }
}