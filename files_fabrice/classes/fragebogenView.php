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
        echo "<td>$InhaltFrage</td>";
    break; 
        } 
    }
}    

?>