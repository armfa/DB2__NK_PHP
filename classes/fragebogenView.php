<?php

class FragebogenView extends Fragebogen{
 
    public function showFragebogenVonBenutzer($benutzer){
    $titel = $this->getFragebogenVonBenutzerStmt($benutzer);
    foreach($titel AS $fragebogen){
        echo "<option value='$fragebogen'>$fragebogen</option>";
    break; 
        } 
    }

    public function showFragenVonFragebogen($fragebogen){
    $frage = $this->getFragenVonFragebogenStmt($fragebogen);
    foreach($frage AS $InhaltFrage){
        echo '<tr><td>',$InhaltFrage,'</td><td><button type="submit" name="loeschen">Frage loeschen</button></td></tr>';
    break; 
        } 
    }
}    

?>