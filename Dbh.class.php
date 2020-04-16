<?php

//Fabrice Armbruster
//12.04.2020
//Diese Klasse stellt eine PDO_Verbindung zur Datenbank her. 
//Zur Einbindung muss auf diese Klasse referenziert werden --> extends Dbh
//Es nutzt dabei das setAttribute mit fetch_assoc als Standarteinstellung, 
//weshalb alle daten als Assoziatives Array zurückgegeben werden. 
//Dies kann bei Bedarf in der entsprechenden Funktion übersteuert werden.  

class Dbh {
  private $host = "localhost";
  private $user = "root";
  private $pwd = "";
  private $dbName = "o8egavzh9f";

  protected function connect() {
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
    $pdo = new PDO($dsn, $this->user, $this->pwd);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
  }
}
?>