<?php
//Fabrice Armbruster

//Diese Klasse führt alle grundlegenden Funktionen in "indexBefragung.php" aus.
//Hierzu zählen folgende Teile der Aufgabenstellung:

// - Prozedur zur Belegung des Kommentarfelds für einen Studenten in einem Fragebogen.
// - Prozedur, die für eine Matrikelnummer und einen Fragebogen die Einträge als abgeschlossen markiert.
// -  Prozedur, um eine für eine Matrikelnummer die gemachte Punktevergabe einträgt (student, fragebogen, frage, punkte).

// Hierfür werden die Datenbank Funktionen der Klasse Befragung genutzt. 

class BefragungController extends Befragung{

    //Antwort speichern/updaten
    public function createOrUpdateFrageAntwortStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort){
        //Check, ob Antwort auf Frage schon abgegeben wurde in DB
        //Falls ja, dann update, wenn Unterschied
        if($this->getSingleAntwort($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer)) {
            $this->setFrageAntwortUpdateStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort);
        }
        //Falls Nein, dann Insert 
        if($this->getSingleAntwort($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer) == false){
            $this->setFrageAntwortStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort);
        }
    }

    //Fragebogen abschließen
    public function createKommentarFragebogenFertig($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus, $kommentar){  
        //Kommentar auf 1 = Abgegeben setzten
        $this->setKommentarUpdateStmt($Fragebogenkuerzel, $Matrikelnummer, 1, $kommentar);
        //Weiterleiten auf Fragebogen-Auswahlseite, erfolgreicher Status mitgeben
        header("Location: ../DB2__NK_PHP/indexBefragungVorauswahl.php?f=success");
    }

    //Kommentar Updaten/Abschließen
    public function createOrUpdateKommentarStmt($Fragebogenkuerzel, $Matrikelnummer, $kommentar){
        //Prüfen, Datensatz (Kommentar) bereits in der Datenbank existiert, aber noch nicht agegeben wurde.
        //Falls ja, dann update Datensatz
        if($this->getSingleKommentar($Fragebogenkuerzel, $Matrikelnummer, 0)) {
            $this->setKommentarUpdateStmt($Fragebogenkuerzel, $Matrikelnummer, 0, $kommentar);
        }
        //Noch kein Eintrag Vorhanden -> Insert Datensatz 
        else{
            $this->setKommentarStmt($Fragebogenkuerzel, $Matrikelnummer, 0, $kommentar);
        }
    }

}
