<?php


class BefragungView extends Befragung{

    public function showAnzahlFragenFragebogenStmt($Fragebogenkuerzel){
        return $this->getAnzahlFragenFragebogenStmt($Fragebogenkuerzel);
    }

    public function showFragebogenTitelStmt($Fragebogenkuerzel){
        return $this->getFragebogenTitelStmt($Fragebogenkuerzel);
    }

    public function showFrageStmt($Fragebogenkuerzel){
        return $this->getFragenStmt($Fragebogenkuerzel);
    }

}

