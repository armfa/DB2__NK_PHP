<?php
//Fabrice Armbruster

//______________________KLASSENBESCHREIBUNG______________________
//Diese Klasse stellt eine PDO-Verbindung zur Datenbank her. 
//Zur Einbindung muss auf diese Klasse referenziert werden --> extends Dbh
//Es nutzt dabei das setAttribute mit fetch_assoc als Standardeinstellung, 
//weshalb alle Daten standartmäßig als Assoziatives Array zurückgegeben werden. 
//Dies kann bei Bedarf in der entsprechenden Funktion übersteuert werden, 
//ebenso wie die die Einstellung FetchAll/Fetch.

//Alle includes werden hier angegeben, da durch die Vererbung diese auch in den Sub-Klassen verfügbar sind. 
//Nur die index*.php-Seiten müssen, da keine Vererbung zu dieser Klasse existiert, in lokal angegeben werden. 

//Kurs
include_once 'classes/kurs.class.php';

//Fragebogen
include_once 'classes/fragebogen.class.php';


//Befragung
include_once 'classes/befragung.class.php';
include_once 'classes/befragungController.php';

//Login
include_once 'classes/benutzer.class.php';

//Ergebnis auswerten
include_once 'classes/ergebnis.class.php';
include_once 'classes/ergebnisController.php';

session_start();


class Dbh
{
  private $host = "localhost";
  private $user = "root";
  private $pwd = "";
  private $dbName = "db";

  protected function connect()
  {
    try {
      $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
      $pdo = new PDO($dsn, $this->user, $this->pwd);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      return $pdo;
    } catch (PDOException $e) {
      header("Location: ../DB2__NK_PHP/indexFehler.php");
    }
  }
}
