<?php
//Fabrice Armbruster
//12.04.2020
//Diese Klasse stellt eine PDO_Verbindung zur Datenbank her. 
//Zur Einbindung muss auf diese Klasse referenziert werden --> extends Dbh
//Es nutzt dabei das setAttribute mit fetch_assoc als Standarteinstellung, 
//weshalb alle daten als Assoziatives Array zurückgegeben werden. 
//Dies kann bei Bedarf in der entsprechenden Funktion übersteuert werden.  

include_once 'classes/exceptionMessage.php';
include_once 'error.php';


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
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $e) {
      $exception = new exceptionMessage();
      $exception->db_connect_failed_message();
    }
  }
}
