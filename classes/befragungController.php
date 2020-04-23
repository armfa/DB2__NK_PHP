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
        
        
        //Prüfen, Datensatz (Kommentar) bereits in der Datenbank existiert, aber noch nicht agegeben wurde.
        //Falls ja, dann update Tuppel mit Abgegebn = 1 und dem Kommentar. 
        if($this->getSingleKommentar($Fragebogenkuerzel, $Matrikelnummer, 0)) {
            $this->setKommentarUpdateStmt($Fragebogenkuerzel, $Matrikelnummer, 1, $kommentar);
        }
        //Noch kein Eintrag Vorhanden -> Insert Datensatz 
        if($this->getSingleKommentar($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus ) == false){
            $this->setKommentarStmt($Fragebogenkuerzel, $Matrikelnummer, 1, $kommentar);
        }
        //Weiterleiten auf Fragebogen-Auswahlseite, erfolgreicher Status mitgeben
        header("Location: ../DB2__NK_PHP/indexBefragungVorauswahl.php?f=success");
    }
}
