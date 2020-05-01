<?php
//Fabrice Armbruster + Dana Gessler
// Klasse zur Ergebnisauswertung

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
                $GLOBALS["exception"]->displayException($e);
                        }
        }
    }


    protected function getAvgAnswer($avgAnswer){
        {
            try {
                $sql = "SELECT avg(Antwort) 
                FROM 		bearbeitet bear, 	
                            beantwortet bean, 
                            student s 
                WHERE 	bear.Matrikelnummer = s.Matrikelnummer  
                AND bear.Matrikelnummer = bean.Matrikelnummer  
                AND s.Matrikelnummer = bean.Matrikelnummer  
                AND bear.Abgabestatus = 1
                AND bean.Fragenummer = bear.Kuerzel
                AND bear.Kuerzel = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$avgAnswer]);
                $ergebnis = $stmt->fetch(PDO::FETCH_ASSOC); 
                return $ergebnis;
            } catch (PDOException $e) {
                $exceptionMessage = new exceptionMessage();
                $exceptionMessage->displayException($e);
            }
        }
    }

    protected function getMinAnswer($minAnswer){
        {
            try {
                $sql = "SELECT min(Antwort) 
                FROM 		bearbeitet bear, 	
                            beantwortet bean, 
                            student s 
                WHERE 	bear.Matrikelnummer = s.Matrikelnummer  
                AND bear.Matrikelnummer = bean.Matrikelnummer  
                AND s.Matrikelnummer = bean.Matrikelnummer  
                AND bear.Abgabestatus = 1
                AND bean.Fragenummer = bear.Kuerzel
                AND bear.Kuerzel = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$minAnswer]);
                $ergebnis = $stmt->fetch(PDO::FETCH_ASSOC); 
                return $ergebnis;
            } catch (PDOException $e) {
                $exceptionMessage = new exceptionMessage();
                $exceptionMessage->displayException($e);
            }
        }
    }

    protected function getMaxAnswer($maxAnswer){
        {
            try {
                $sql = "SELECT max(bean.Antwort) 
                FROM 		bearbeitet bear, 	
                            beantwortet bean, 
                            student s 
                WHERE 	bear.Matrikelnummer = s.Matrikelnummer  
                AND bear.Matrikelnummer = bean.Matrikelnummer  
                AND s.Matrikelnummer = bean.Matrikelnummer  
                AND bear.Abgabestatus = 1
                AND bean.Fragenummer = bear.Kuerzel
                AND bear.Kuerzel = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$maxAnswer]);
                $ergebnis = $stmt->fetch(PDO::FETCH_ASSOC); 
                return $ergebnis;
            } catch (PDOException $e) {
                $exceptionMessage = new exceptionMessage();
                $exceptionMessage->displayException($e);
            }
        }
    }

    protected function getStandDeviation(){
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