<?php

//Fabrice Armnbruster 

class exceptionMessage extends dbh {

    public function displayException($e)
    {   
        $this->redirectToErrorPage($e, 1);
        //echo "<error><p>Your satisfaction is the most important. This is why we work all night and day on fixing this. In the meantime, you could check the weather, if its worth of getting some fresh air:)</p><errorCode>".$e."<errorCode></error>";
    }

    public function db_connect_failed_message()
    {   
        $e = "<error><p>Your satisfaction is the most important. This is why we work all night and day on fixing this. In the meantime, you could check the weather, if its worth of getting some fresh air:)</p><errorCode>Error -> Die Datenbankverbindung konnte nicht herrgestellt werden.<errorCode></error>";
        $this->redirectToErrorPage($e, 2);
    }

    private static function redirectToErrorPage($e, $number){
       // header("Location: http://localhost/DB2__NK_PHP/error.php/?e=$e");
        echo $e;
    }


}



?>
