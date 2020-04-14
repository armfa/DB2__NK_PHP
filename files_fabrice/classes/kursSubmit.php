<?php

include_once 'dbh.class.php';
include_once 'kurs.class.php';
include_once 'kursController.php';
include_once 'kursView.php';
include_once 'kursSubmit.php';

if(isset($_POST['kursAnlegen'])){
    $kursname = $_POST['Kurs'];
    $kursObj = new kursController();
    $kursObj->createKurs($kursname);
    }