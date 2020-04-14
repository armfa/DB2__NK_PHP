<?php

class kursController extends kurs{

    public function createKurs($kursname){
        $this->setKursStmt($kursname);  
    }

    public function createStudent($matrikelnummer, $studentenname, $kursname)
    {
        $this->setStudentStmt($matrikelnummer, $studentenname, $kursname);
    }


}