<?php


class BefragungController extends Befragung{

    public function createOrUpdateFrageAntwortStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort){
        //Check, ob Antwort auf Frage schon abgegeben wurde in DB
        //Falls ja, dann update, wenn Unterschied
        if($this->getSingleAntwort($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer)[0]['Antwort'] != $Antwort AND $this->getSingleAntwort($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer)[0]) {
            $this->setFrageAntwortUpdateStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort);
        }
        //Falls Nein, dann Insert 
        if($this->getSingleAntwort($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer)[0] == false){
            $this->setFrageAntwortStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort);
        }
    }

    public function createKommentarFragebogenFertig($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus, $kommentar){
        //Check, ob Kommentar auf Frage schon abgegeben wurde in DB
        //Falls ja, dann update, wenn Unterschied
        print_r($this->getSingleKommentar($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus));
        if($this->getSingleKommentar($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus) == false) {
            echo "1</br>";
            $this->setKommentarUpdateStmt($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus, $kommentar);
        }
        //Falls Nein, dann Insert 
        if($this->getSingleKommentar($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus) != false){
            echo "2</br>";
            $this->setKommentarStmt($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus, $kommentar);
        }
    }
}
