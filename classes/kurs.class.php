<?php
//Fabrice Armbruster

//Diese Klasse beinhaltet alle Funktionen bezüglich des "Kurses".
//Hierzu zählen die Funktionen
// - getKurses() --> returns Array mit Kursen
// - getStudentenVonKurs() -> returns Array mit Studenten eines Kurses
// - setKurs() --> Fügt Kurs in DB hinzu
// - deleteKurs() --> Löscht Kurs in der DB
// - setStudent() --> Fügt Student DB hinzu
// - deleteStudent() --> Löscht Student in der DB 
// - getKuresfromBenutzerStmt() --> returns Array mit Kursen dieses Benutzers

//ToDo: Error Handling is missing -> DB-Server side is done


class Kurs extends Dbh
{

    protected function getKurses()
    {
        try {
            $sql = "SELECT * FROM Kurs";
            $stmt = $this->connect()->query($sql);
            $kurses = $stmt->fetch();
            return $kurses;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function checkIfKursExists($kurs)
    {
        try {
            $sql = "SELECT * from kurs Where Kursname = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$kurs]);
            $kursname = $stmt->fetch(PDO::FETCH_ASSOC);
            return $kursname;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function getKuresfromBenutzerStmt($benutzer)
    {
        try {
            $sql = "SELECT k.* FROM kurs k,freischalten f, fragebogen fr, benutzer b WHERE k.Kursname = f.Kursname AND f.Kuerzel = fr.Kuerzel AND fr.Benutzername = b.Benutzername AND b.Benutzername = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$benutzer]);
            $kursname = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $kursname;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function setKursStmt($Kursname)
    {
        try {
            $sql = "INSERT INTO kurs (Kursname) VALUES (?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Kursname]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function deleteKursStmt($Kursname)
    {
        try {
            $sql = "DELETE FROM kurs WHERE Kursname = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Kursname]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function getStudentenVonKursStmt($Kursname)
    {
        try {
            $sql = "SELECT * FROM student WHERE Kursname = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Kursname]);
            $student = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $student;
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function checkIfStudentExists($matrikelnummer){
        {
            try {
                $sql = "SELECT * from student Where matrikelnummer = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$matrikelnummer]);
                $kursname = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $kursname;
            } catch (PDOException $e) {
                $exceptionMessage = new exceptionMessage();
                $exceptionMessage->displayException($e);
            }
        }
    }


    protected function setStudentStmt($Matrikelnummer, $Studentenname, $Kursname)
    {
        try {
            $sql = "INSERT INTO student (Matrikelnummer, Studentenname, Kursname) VALUES (?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Matrikelnummer, $Studentenname, $Kursname,]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }

    protected function deleteStudentStmt($Matrikelnummer)
    {
        try {
            $sql = "DELETE FROM student WHERE Matrikelnummer = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$Matrikelnummer]);
        } catch (PDOException $e) {
            $exceptionMessage = new exceptionMessage();
            $exceptionMessage->displayException($e);
        }
    }
}
