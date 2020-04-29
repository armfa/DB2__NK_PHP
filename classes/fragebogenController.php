<?php

class FragebogenController extends Fragebogen{

    public function createFragebogen($fragebogen, $benutzername){
        $this->setFragebogenStmt($fragebogen, $benutzername);     
    }

    public function createFrage($inhaltFrage, $kuerzel){
        $this->setFrageStmt($inhaltFrage, $kuerzel);
    }

    public function checkFragebogen($titelFragebogen){
        return $this->checkObFragebogenExistiert($titelFragebogen);
    }

    public function checkFrage($titelFrage, $kuerzel){
        return $this->checkObFrageExistiert($titelFrage, $kuerzel);
    }

    public function deleteFragebogen($kuerzel){
        $this->deleteFragebogenStmt($kuerzel);
    }

    public function deleteFrage($fragenummer){
        $this->deleteFragebogenStmt($fragenummer);
    }

    public function kuerzelVonFragebogen($titelFragebogen){
        $this->getKuerzelVonFragebogen($titelFragebogen);
    }

    public function checkFreigabe($kuerzel, $kursname){
        $this->checkObFreischaltungExistiert($kuerzel, $kursname);
    }

    public function fragebogenFreischalten($kuerzel, $kursname){
        $this->setFreischaltungStmt($kuerzel, $kursname);       
    }

}