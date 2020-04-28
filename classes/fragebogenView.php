<?php
session_start();
?>
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
    $i = 0;
    while($i < count($frage)){
        echo "<option value='".$frage[$i]['Fragenummer']."'>".$frage[$i]['InhaltFrage']."</option>";
        $i++;
        } 
    }
}    

?>