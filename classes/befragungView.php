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

    public function showFragebogenfromBenutzer($benutzer){
        $fragebogen = $this->getFragebogenfromBenutzer($benutzer);
        foreach($fragebogen AS $umfrage){
            echo "<option value='$umfrage'>$umfrage</option>";
        break; 
            } 
    }

    public function showFrageAntwortStmt($Fragebogenkuerzel, $Matrikelnummer)
    {
       return $this->getFrageAntwortStmt($Fragebogenkuerzel, $Matrikelnummer);  
    }
}

