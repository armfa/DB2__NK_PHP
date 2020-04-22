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
        $i = 0;
        while($i < count($fragebogen)){
            echo "<option value='".$fragebogen[$i]['Kuerzel']."'>".$fragebogen[$i]['Titel']."</option>";
            $i++;
            } 
    }

    public function showFrageAntwortStmt($Fragebogenkuerzel, $Matrikelnummer)
    {
       return $this->getFrageAntwortStmt($Fragebogenkuerzel, $Matrikelnummer);  
    }
}

