<?php
//Dana Geßler
// 11.05.2020

//______________________KLASSENBESCHREIBUNG______________________
//Diese Klasse enthält die SQL-Statements zur Abprüfung von Nutzername und Passwort bei Login auf die Datenbank
//setBenutzerStmt() --> fügt neuen Benutzer mit eingegebenen Daten in DB ein
//getBenutzerStmt() --> prüft DB auf existierenden Benutzer
//getStudentStmt() --> prüft DB auf existierenden Studenten

include_once 'classes/dbh.class.php';

class Benutzer extends Dbh
{


	public function setBenutzerStmt($Benutzername, $Passwort)
	{
		try {
			$sql = "INSERT INTO benutzer (Benutzername, Passwort) VALUES (?, ?)";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$Benutzername, $Passwort]);
		} catch (PDOException $e) {
			header("Location: ../DB2__NK_PHP/indexFehler.php");
		}
	}

	public function getBenutzerStmt($Benutzername)
	{
		try {
			$sql = "SELECT * FROM benutzer WHERE Benutzername = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$Benutzername]);
			$benutzer = $stmt->fetch(PDO::FETCH_ASSOC);
			return $benutzer;
		} catch (PDOException $e) {
			header("Location: ../DB2__NK_PHP/indexFehler.php");
		}
	}

	public function getStudentStmt($Matrikelnummer)
	{
		try {
			$sql = "SELECT * FROM student WHERE Matrikelnummer = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$Matrikelnummer]);
			$student = $stmt->fetch(PDO::FETCH_ASSOC);
			return $student;
		} catch (PDOException $e) {
			header("Location: ../DB2__NK_PHP/indexFehler.php");
		}
	}
}
