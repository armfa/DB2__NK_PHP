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
        //Kommentar auf 1 = Abgegeben setzten
        $this->setKommentarUpdateStmt($Fragebogenkuerzel, $Matrikelnummer, 1, $kommentar);
        //Weiterleiten auf Fragebogen-Auswahlseite, erfolgreicher Status mitgeben
        header("Location: ../DB2__NK_PHP/indexBefragungVorauswahl.php?f=success");
    }

    public function createOrUpdateKommentarStmt($Fragebogenkuerzel, $Matrikelnummer, $kommentar){
        //Prüfen, Datensatz (Kommentar) bereits in der Datenbank existiert, aber noch nicht agegeben wurde.
        //Falls ja, dann update Datensatz
        if($this->getSingleKommentar($Fragebogenkuerzel, $Matrikelnummer, 0)) {
            $this->setKommentarUpdateStmt($Fragebogenkuerzel, $Matrikelnummer, 0, $kommentar);
        }
        //Noch kein Eintrag Vorhanden -> Insert Datensatz 
        else{
            $this->setKommentarStmt($Fragebogenkuerzel, $Matrikelnummer, 0, $kommentar);
        }
    }
}
