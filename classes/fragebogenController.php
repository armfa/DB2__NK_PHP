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


}