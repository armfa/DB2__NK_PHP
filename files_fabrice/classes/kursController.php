<?php
//Fabrice Armbruster

class kursController extends kurs{

    public function createKurs($kursname){
        $this->setKursStmt($kursname);  
    }

    public function createStudent($matrikelnummer, $studentenname, $kursname)
    {
        $this->setStudentStmt($matrikelnummer, $studentenname, $kursname);
    }

    public function checkStudent($matrikelnummer)
    {
        return $this->checkIfStudentExists($matrikelnummer);
    }

    public function checkKurs($matrikelnummer)
    {
        return $this->checkIfKursExists($matrikelnummer);
    }
}