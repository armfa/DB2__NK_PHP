<?php


class BefragungController extends Befragung{

    public function createOrUpdateFrageAntwortStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort){
        //Check, ob Antwort schon in DB
        //Falls ja, dann update, wenn Unterschied

/*         print_r($this->getSingleAntwort($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer)[0]['Antwort']);
 */
        if($this->getSingleAntwort($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer)[0]['Antwort'] == $Antwort) {
            echo "if</br>";
            $this->setFrageAntwortUpdateStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort);
        }
        //Falls Nein, dann Insert 
        else{
            $this->setFrageAntwortStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort);
        }
    }

}