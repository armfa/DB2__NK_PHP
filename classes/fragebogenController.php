<?php
session_start();
?>
<?php

class fragebogenController extends Fragebogen{

    public function createFragebogen($fragebogen, $benutzername){
        $this->setFragebogenStmt($fragebogen, $benutzername);     
    }

    public function createFrage($inhaltFrage, $kuerzel){
        $this->setFrageStmt($inhaltFrage, $kuerzel);
    }

    public function checkFragebogen($titelFragebogen){
        return $this->checkObFragebogenExistiert($titelFragebogen);
    }

    public function checkFrage($titelFrage){
        return $this->checkObFrageExistiert($titelFrage);
    }

    public function deleteFragebogen($kuerzel){
        $this->deleteFragebogenStmt($kuerzel);
    }

    public function deleteFrage($fragenummer){
        $this->deleteFragebogenStmt($fragenummer);
    }

    public function fragebogenFreischalten($kuerzel, $kursname){
        $this->setFreischaltungStmt($kuerzel, $kursname);
    }


}