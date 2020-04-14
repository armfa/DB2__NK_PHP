<?php
//Fabrice Armbruster
//
//Diese Klasse stellt eine Verbindung zur Datenbank her.
//https://www.youtube.com/watch?v=PHiu0JA9eqE 


//Die Attribute der Klasse sind private, damit nur aus der Klasse heraus zugegriffen werden kann. --> Schutz
class dbVerbindung{

        private $servername;
        private $benutzername;
        private $passwort;
        private $dbname;  

//Einziger Weg diese Funktion zu benutzen ist es eine Klasse aufzurufen, welche einer subklasse dieser ist. 
protected function connect(){
    $this->servername = "localhost";
    $this->benutzername = "root";
    $this->passwort = "";
    $this->dbname = "o8EGaVZh9F";

    $conn = new mysqli($this->servername, $this->benutzername, $this->passwort, $this->dbname);
    return $conn;
}

}