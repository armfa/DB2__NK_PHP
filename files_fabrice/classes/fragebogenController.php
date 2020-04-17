<?php

class fragebogenController extends Fragebogen{

    public function createFragebogen($fragebogen, $benutzername){
        if ($this->getTitelFragebogen($fragebogen) == false){
            $this->setFragebogenStmt($fragebogen, $benutzername);     
        }
        else {
            echo "Es existiert bereits einen gleichnamigen Fragebogen";
        }
         
    }

    public function createFrage($inhaltFrage, $kuerzel){
        if ($this->getInhaltFrage($inhaltFrage) == false){
            $this->setFrageStmt($inhaltFrage, $kuerzel);
        } 
        else {
            echo "Es existiert bereits eine gleichnamige Frage";
        }   
    }


}