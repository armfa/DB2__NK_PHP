<?php
// Dana Geßler 30.4.2020

class ErgebnisView extends Ergebnis
{

    public function showFragebogenBenutzerKurs($fragebogen)
    { 
    }

    //Aufruf getKommentareStmt
    public function showKommentare($alleKommentare){
        $kommentar = $this->kommentar;
        $this->getKommentareStmt($kommentar);
        $alleKommentare = $kommentar; 
        return $alleKommentare;
    }

    public function showBerechnungenJeFragejeKurs($auswertung)
    {   
    // Aufrufe für Antworten (avg, min, max, standDev)
        $avgAnswer = $this->avgAnswer;
        $this->getAvgAnswerStmt($avgAnswer);

        $minAnswer = $this->minAnswer;
        $this->getMinAnswerStmt($minAnswer);

        $maxAnswer = $this->maxAnswer;
        $this->getMaxAnswerStmt($maxAnswer);

        $standDev = $this->standDev;
        $this->getStandDevStmt($standDev);

        $auswertung = array($avgAnswer, $minAnswer, $maxAnswer, $standDev);

        return $auswertung;

        
    }
}