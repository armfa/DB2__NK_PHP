<?php
  include_once 'classes/kurs.class.php';

//Fabrice Armbruster
//13.04.2020

//Diese Klasse bildet und verarbeitet das FrontEnd zu den Funktionaliäten der Klasse "Kurs"

class KursView extends Kurs
{

    public function showKursesfromBenutzer($benutzer)
    {
        //Diese Methode zeigt auf der indexklass.php-Seite eine Drop-Down-Liste an, die  mit den möglichen Werten für einen Benutzer gefüllt ist.  

        $kursname = $this->getKuresfromBenutzerStmt($benutzer);
        $i = 0;
        while ($i < count($kursname)) {
            echo "<option value='" . $kursname[$i]['Kursname'] . "'>" . $kursname[$i]['Kursname'] . "</option>";
            $i++;
        }
    }
}
