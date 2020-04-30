<?php
//Fabrice Armbruster

//________________________BESCHREIBUNG______________________
//Diese Seite dient als Vorauswahl, auf der der Student die für ihn 
//freigeschalteten und noch nicht abgegebenen Umfragen aufrufen kann. 
//Dafür wird er weitergeleitet auf die indexBefragung.php

include_once 'classes/dbh.class.php';

//Diese Seite akzeptiert nur Studenten
if (isset($_SESSION['matrikelnummer']) == false) {
    //Falls Student nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
    //Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}
?>

<!doctype HTML>
<html>

<body>
    <h1>Welche Umfrage möchten Sie starten?</h1>

<?php
    if (isset($_GET['k'])) {
        echo "<p class='success'>Sie haben den Fragebogen erfolgreich abgeschickt!</p>";
    }
?>


<form action="indexBefragung.php" method="post">
        <label>Fragebogen</label>
        <select name="fragebogen">
            <?php
            //Dropdownauswahl des Fragebogens, welcher für diesen Student freigeschalten ist. 
            //ToDo: aktueller Benutzer Übergeben     
            $bContr = new BefragungView();
            $bContr->showFragebogenfromStudentAbgabestatusStnmt($_SESSION['matrikelnummer'], 0);//ToDo: benutzer einbinden
            ?>
        </select></br>
        <button type="submit" name="umfrageStarten">Umfrage starten</button>
    </form>
</body>




</html>