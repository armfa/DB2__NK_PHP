<?php
// Dana Geßler 30.4.2020

class ErgebnisView extends Ergebnis
{

    public function showFragebogenBenutzerKurs($Fragebogen, $Kurs)
    { 
    }

    //Aufruf getKommentareStmt
    public function showKommentare($Fragebogen, $Kurs){
        $kommentarArray = $this->kommentarArray;
        $this->getKommentareStmt($Fragebogen, $Kurs);
        $alleKommentare = $kommentarArray; 
        return $alleKommentare;
    }

    public function showBerechnungenJeFragejeKurs($Fragebogen, $Kurs)
    {   
    // Aufrufe für Antworten (avg, min, max, standDev)
        $avgAnswer = $this->avgAnswer;
        $this->getAvgAnswerStmt($Fragebogen, $Kurs);

        $minAnswer = $this->minAnswer;
        $this->getMinAnswerStmt($Fragebogen, $Kurs);

        $maxAnswer = $this->maxAnswer;
        $this->getMaxAnswerStmt($Fragebogen, $Kurs);

        $standDev = $this->standDev;
        $this->getStandDevStmt($Fragebogen, $Kurs);

        $auswertung = array($avgAnswer, $minAnswer, $maxAnswer, $standDev);

        return $auswertung;

        
    }
}