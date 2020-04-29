<?php

//Fabrice Armnbruster

//______________________KLASSENBESCHREIBUNG______________________
//Diese Klasse verwaltet alle Fehlermeldungen und ist die Exception-Klasse der PDO-DB-Zugriffe.
//Vorteil liegt in der losen Kopplung und zentralen Wartbarkeit. 

class exceptionMessage extends dbh {

    private $msg1 = '<error><p>Sie sind am Wichtigsten für uns. Leider gab es trotzdem einen Fehler in der Datenbank.
    Bitte versuchen Sie es einfach erneut.</p><errorCode>Fehler: ';
    private $msg2 = '</errorCode></error></br>';

    public function displayException($e)
    { 
        echo $this->msg1.$e->getCode().$this->msg2;
        //Exit, damit nicht die Error-Info angezeigt bekommt. 
        exit();
    }
}

?>
