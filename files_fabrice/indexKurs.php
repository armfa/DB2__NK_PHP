<?php
  include_once 'classes/dbh.class.php';
  include_once 'classes/kurs.class.php';
  include_once 'classes/kursController.php';
  include_once 'classes/kursView.php';
  include_once 'classes/kursSubmit.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kurs</title>
</head>
<body>   
    <h1>This is the Kurs Page.</h1>

        <a link="index.php">

<?php
    $kursObj = new kursController();
if(isset($_POST['kursAnlegen'])){
    $kursname = $_POST['Kurs'];
    $kursObj->createKurs($kursname);
    }
if(isset($_POST['studentAnlegen'])){
    $kursname = $_POST['kurses'];
    $matrikelnummer = $_POST['matrikelnummer'];
    $studentenname = $_POST['studentenname'];
    $kursObj->createStudent($matrikelnummer, $studentenname, $kursname);
    }
 ?>

<h3>Neuen Kurs anlegen</h3>
     
    <form class='neuerKurs-form' action="" method="post">
        <input type="text" name="Kurs" placeholder="Kurs">
        <button type="submit" name="kursAnlegen">Kurs anlegen</button>
    </form>   
<h3>Neuen Student anlegen</h3>
    <form class='neuerStudent-form' action="" method="post">
        <label>Kurs</label>
        <select name="kurses">
            <?php
                //Dropdownauswahl des Kurses
                //ToDo: aktueller Benuttzer Übergeben     
                $benutzerObject = new KursView();
                $benutzerObject->showKursesfromBenutzer('user1');
            ?>
        </select></br>
        <input type="text" name="matrikelnummer" placeholder="Matrikelnummer" maxlength="7"></br>
        <input type="text" name="studentenname" placeholder="Name">
        <button type="submit" name="studentAnlegen">Student anlegen</button>
    </form>   
        
<!--
        Kurs <input type="text" name="kurs"><br>
        <p>Welche Studenten möchten Sie anlegen und dem Kurs hinzufügen?</p>
        Matrikelnummer<input type="text" name="matrikelnummerStudent">
        Name<input type="text" name="matrikelnummerStudent">
        Kurs<input type="text" name="matrikelnummerStudent">
        <input type="submit" name="studentHinzufügen" value="+"/><br>
        <input type="submit" name="neuerKursAnlegen" value="Neuen Kurs anlegen"/>
    </form>  
    

        <form action="http://vorlesungen.kirchbergnet.de/inhalte/DB-PR/output_posted_vars.php" method="post">
<form id="neuerKurs">
  <label >Kurs</label> 
  <input name="KursnameStudent" id="KursnameStudent"></br>
  <input type="submit" name="neuerKursAnlegen" value="Neuen Kurs anlegen"/></br>
  
  <h3>Neuen Student anlegen</h3>
  <label >Matrikelnummer</label>
  <input name="Matrikelnummer" id="Matrikelnummer" maxlength="7"></br>
  <label >Name Student</label> 
  <input name="Studentenname" id="Studentenname"></br>
  <label >Kurs</label> 

 
  <input type="submit" name="studentHinzufügen" value="Student hinzufügen"/><br>
</form>
    -->
    
    <?php
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
    //print_r($testKurs->getKuresfromBenutzerStmt('Benutzer2')); 
    ?>

</body>
</html>