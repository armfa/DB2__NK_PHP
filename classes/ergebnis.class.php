<?php
//Fabrice Armbruster 

class Ergebnis extends dbh{

    protected function getKommentareStmt(){
        {
            try {
                //SQL missing 
                /* $sql = "SELECT * from bearbeitet b Where matrikelnummer = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$matrikelnummer]);
                $kommentare = $stmt->fetch(PDO::FETCH_ASSOC); 
                return $kommentare;*/
            } catch (PDOException $e) {
                $exceptionMessage = new exceptionMessage();
                $exceptionMessage->displayException($e);
            }
        }
    }


}