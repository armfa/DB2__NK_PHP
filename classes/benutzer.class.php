<?php
//Dana Geßler	
//Diese Klasse selektiert Benutzername und Passwort zur Abprüfung auf die Datenbank, 
//und kann neue Registrierungen bei nicht vorhandenen Nutzern durchführen. 

include_once 'classes/dbh.class.php';

class Benutzer extends Dbh {

		public function setBenutzerStmt($Benutzername, $Passwort){
			try{
			$sql="INSERT INTO benutzer (Benutzername, Passwort) VALUES (?, ?)";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$Benutzername, $Passwort]);
		} catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
		}
		}
		
		public function getBenutzerStmt($Benutzername){
			try{
			$sql="SELECT * FROM benutzer WHERE Benutzername = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$Benutzername]);
			$benutzer = $stmt->fetch(PDO::FETCH_ASSOC);
			return $benutzer;
		} catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
		}
		}

		public function checkPasswordStmt($Passwort){
			try{
			$sql="SELECT Count benutzer FROM benutzer WHERE Passwort = ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$Passwort]);
			$count = $stmt->fetch(PDO::FETCH_ASSOC);
			return $count;
		} catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
		}
		}

		public function getStudentStmt($Matrikelnummer){
			try{
				$sql="SELECT * FROM student WHERE Matrikelnummer = ?";
				$stmt = $this->connect()->prepare($sql);
				$stmt->execute([$Matrikelnummer]);
				$student = $stmt->fetch(PDO::FETCH_ASSOC);
				return $student;
			} catch (PDOException $e) {
            header("Location: ../DB2__NK_PHP/indexFehler.php");
			}
		}

	}