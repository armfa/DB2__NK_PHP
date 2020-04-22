<?php

class FragebogenView extends Fragebogen{
 
    public function showFragebogenVonBenutzer($benutzer){
    $titel = $this->getFragebogenVonBenutzerStmt($benutzer);
        $i = 0;
        while($i < count($titel)){
            echo "<option value='".$titel[$i]['Kuerzel']."'>".$titel[$i]['Titel']."</option>";
            $i++;
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