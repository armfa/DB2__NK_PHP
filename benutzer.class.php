<?php

//Dana Geßler	
//16.04.2020
//Diese Klasse selektiert Benutzername und Passwort zur Abprüfung auf die Datenbank, und kann neue Registrierungen bei nicht vorhandenen Nutzern durchführen. 

include_once 'OO_login/Dbh.class.php';

class Benutzer extends Dbh {

		public function getLoginStmt($Benutzername, $Passwort){
        try {
			$sql="SELECT * FROM benutzer WHERE Benutzername= ? and Passwort= ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$Benutzername, $Passwort]);
			$userdata = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $userdata;
        } catch (PDOException $e) {
			echo $e;
        }
		}

		public function setBenutzerStmt($Benutzername, $Passwort){
			try{
			$sql="INSERT INTO benutzer (Benutzername, Passwort) VALUES (?, ?)";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$Benutzername, $Passwort]);
			$userdata = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo $e;
        }
		}
		

		public function getBenutzerStmt($Benutzername){
			try{
			$sql="SELECT * FROM benutzer WHERE Benutzername= ?";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$Benutzername]);
			$benutzer = $stmt->fetch(PDO::FETCH_ASSOC);
			return $benutzer;
		} catch (PDOException $e) {
			echo $e;
        }
		}

	}
	
