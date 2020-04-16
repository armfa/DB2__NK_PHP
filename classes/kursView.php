<?php

//Fabrice Armbruster
//13.04.2020

//Diese Klasse bildet und verarbeitet das FrontEnd zu den Funktionaliäten der Klasse "Kurs"

class KursView extends Kurs{

    //Diese Methode zeigt auf der indexklass.php-Seite eine Drop-Down-Liste an, die  mit den möglichen Werten für einen Benutzer gefüllt ist.  
    public function showKursesfromBenutzer($benutzer){
    $kursname = $this->getKuresfromBenutzerStmt($benutzer);
    foreach($kursname AS $kurs){
        echo "<option value='$kurs'>$kurs</option>";
    break; 
        } 
    }
}    







