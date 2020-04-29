<?php

//Fabrice Armnbruster

//______________________KLASSENBESCHREIBUNG______________________
//Diese Klasse bündelt alle Fehlermeldungen und ist die Exption-Klasse der PDO-DB-Zugriffe.

class exceptionMessage extends dbh {

    private $msg1 = '<error><p>Your satisfaction is the most important. This is why we work all night and day on fixing this. In the meantime, you could check the weather, if its worth of getting some fresh air:)</p><errorCode>';
    private $msg2 = '<errorCode></error></br>';

    public function displayException($e)
    { 
        echo $this->msg1.$e.$this->msg2;
    }

    public function db_connect_failed_message($e)
    {   
        echo $this->msg1.'Es gab ein Problem mit der Verbindung zur Datenbank, bitte probieren Sie es später noch einmal!'.$this->msg2;
    }
}

?>
