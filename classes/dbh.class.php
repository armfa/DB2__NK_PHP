<?php
//Fabrice Armbruster

//______________________KLASSENBESCHREIBUNG______________________
//Diese Klasse stellt eine PDO_Verbindung zur Datenbank her. 
//Zur Einbindung muss auf diese Klasse referenziert werden --> extends Dbh
//Es nutzt dabei das setAttribute mit fetch_assoc als Standardeinstellung, 
//weshalb alle Daten als Assoziatives Array zurückgegeben werden. 
//Dies kann bei Bedarf in der entsprechenden Funktion übersteuert werden, 
//ebenso wie die die Einstellung FetchAll/Fetch.


//Alle includes werden hier angegeben, da durch die Vererbung diese auch in den Sub-Klassen verfügbar sind. 
//Nur die index*.php-Seiten müssen, da keine Vererbung zu dieser Klasse existiert, in diesen Klassen angegeben werden. 

//Kurs
include_once 'classes/kurs.class.php';

//Fragebogen
include_once 'classes/fragebogen.class.php';
include_once 'classes/fragebogenController.php';
include_once 'classes/fragebogenView.php';

//Befragung
include_once 'classes/befragung.class.php';
include_once 'classes/befragungController.php';
include_once 'classes/befragungView.php';

//Exception 
include_once 'classes/exceptionMessage.php';

//Login
include_once 'classes/benutzer.class.php';

session_start();

//Exception-Objekt zentral angelegt, damit die Wartung vereinfacht wird. 
//Ansonsten müsste es bei jedem DB-Aufruf mit angegeben werden. 
$_SESSION['exception'] = new exceptionMessage();

class Dbh
{
  private $host = "localhost";
  private $user = "root";
  private $pwd = "";
  private $dbName = "dhbw";

  protected function connect()
  {
    try {
      $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
      $pdo = new PDO($dsn, $this->user, $this->pwd);
      $pdo->setAttribute(PDO::ERRMODE_SILENT, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $e) {
      $_SESSION['exception']->db_connect_failed_message($e);
    }
  }
}
