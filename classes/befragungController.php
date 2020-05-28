<?php
//Fabrice Armbruster

//______________________KLASSENBESCHREIBUNG______________________
//Diese Klasse führt alle grundlegenden Funktionen in "indexBefragung.php" aus.
//Hierzu zählen folgende Teile der Aufgabenstellung:

// - Prozedur zur Belegung des Kommentarfelds für einen Studenten in einem Fragebogen.
// - Prozedur, die für eine Matrikelnummer und einen Fragebogen die Einträge als abgeschlossen markiert.
// - Prozedur, um eine für eine Matrikelnummer die gemachte Punktevergabe einträgt (student, fragebogen, frage, punkte).
// - Funktion, die prüft, ob ein Student einen Fragebogen ausfüllen darf. 

// Hierfür werden die Datenbankfunktionen der Klasse "Befragung" genutzt. 

class BefragungController extends Befragung
{

    //Antwort speichern/updaten
    public function createOrUpdateFrageAntwortStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort)
    {
        //Check, ob Antwort auf Frage schon abgegeben wurde in DB
        //Falls ja, dann update, wenn Unterschied
        if ($this->getSingleAntwort($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer)) {
            $this->setFrageAntwortUpdateStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort);
        }
        //Falls Nein, dann Insert 
        if ($this->getSingleAntwort($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer) == false) {
            $this->setFrageAntwortStmt($Fragenummer, $Fragebogenkuerzel, $Matrikelnummer, $Antwort);
        }
    }

    //Fragebogen abschließen
    public function createKommentarFragebogenFertig($Fragebogenkuerzel, $Matrikelnummer, $Abgabestatus, $kommentar)
    {
        //Kommentar auf 1 = Abgegeben setzten
        $this->setKommentarUpdateStmt($Fragebogenkuerzel, $Matrikelnummer, 1, $kommentar);
        //Weiterleiten auf Fragebogen-Auswahlseite, erfolgreicher Status mitgeben
        header("Location: ../DB2__NK_PHP/indexBefragungVorauswahl.php?f=success");
    }

    //Kommentar Updaten/Abschließen
    public function createOrUpdateKommentarStmt($Fragebogenkuerzel, $Matrikelnummer, $kommentar)
    {
        //Prüfen, Datensatz (Kommentar) bereits in der Datenbank existiert, aber noch nicht agegeben wurde.
        //Falls ja, dann update Datensatz
        if ($this->getSingleKommentar($Fragebogenkuerzel, $Matrikelnummer, 0)) {
            $this->setKommentarUpdateStmt($Fragebogenkuerzel, $Matrikelnummer, 0, $kommentar);
        }
        //Noch kein Eintrag Vorhanden -> Insert Datensatz 
        else {
            $this->setKommentarStmt($Fragebogenkuerzel, $Matrikelnummer, 0, $kommentar);
        }
    }

    //Darf ein Student einen Fragebogen ausfüllen? -> Funktion gibt Array mit den Fragebögen zurück
    public function darfStudentFragebogenausfuellen()
    {
        //Alle Fragebögen des Studenten, die abgegeben sind. 
        $fragebogen = $this->getFragebogenfromStudentAbgabestatusStnmt($_SESSION['matrikelnummer'], 1);
        //Alle Fragebögen die für den Studenten freigeschaltet sind, unabhängig der  bearbeitung oder abgabe
        $fragebogen2 = $this->getFragebogenfromStudent($_SESSION['matrikelnummer']);
        //Arrays vergleichen (MINUS) -> Unterschiede werden angezeigt
        //Sind sie gleich groß? -> Dann sind alle Bedfragungen schon abgegeben!
        if (count($fragebogen) != count($fragebogen2)) {
            foreach ($fragebogen2 as $singleArray) {
                //Nach selben DS im anderen Array suchen
                /*echo "Array-Ebene 1 ";
                        print_r($singleArray);
                        echo "</br>"; */
                if (count($fragebogen) != 0) {
                    foreach ($fragebogen as $compareArray) {
                        /*echo "Array-Ebene 2 ";
                                print_r($compareArray);
                                echo "</br>"; */
                        //prüfen ob es keine treffer gibt
                        if (count(array_diff_assoc($singleArray, $compareArray)) != 0) {
                            //Wenn es kein Treffer hat -> noch nicht abgegeben in array!
                            $resultx[] = $singleArray;
                            return $resultx;
                        }
                    }
                } else {
                    $resultx[] = $singleArray;
                    return $resultx;
                }
            }
        } else {
            //Keine Treffer -> keine Fragebögen freigeschaltet bzw. alle schon abgeschlossen. 
            return $resultx = null;
        }
    }
}
