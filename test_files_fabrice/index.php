<?php
  //include_once 'includes/class-autoload.inc.php';
  include_once 'classes/dbh.class.php';
  include_once 'classes/test.class.php';
  include_once 'classes/kurs.class.php';


  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
  <?php
    $testObj = new Test();
    $testObj->getUsers();
    $testObj->getUsersStmt("Benutzer1", "passwort1");
    $testObj->setUsersStmt("Benutzer3", "Passwort3");
    
    $testKurs = new Kurs();
    //print_r($testKurs->getKurses());
    //echo $testKurs->getKurses()['Kursname'];
    //echo $testKurs->getStudentenVonKursStmt("WWI318")['Studentenname'];
    //print_r($testKurs->getStudentenVonKursStmt("WWI318"));
    //$testKurs->setKursStmt("WWI118");
    //$testKurs->deleteKursStmt("WWI118");
    //$testKurs->setStudentStmt("2896613", "Student2", "WWI118");
    //$testKurs->setStudentStmt("2896614", "Student2", "WWI118");
    //$testKurs->setStudentStmt("2896615", "Student2", "WWI118");
    //$testKurs->deleteStudentStmt("1234567");
    print_r($testKurs->getKuresfromBenutzerStmt('Benutzer2')); 
 
 ?>
</body>
</html>