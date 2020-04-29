<?php
//session_start();


include_once 'classes/dbh.class.php';

$fragebogenView = new FragebogenView();
$fragebogenCon = new FragebogenController();
$kursView = new KursView();

session_start();
//Input-Felder Fragebogen Anlegen laden

?>

<h4>Fragebogen bearbeiten</h4>

<?php
//ToDO
//Frage löschen
//echo $_POST['fragebogenBearbeiten'];
if(isset($_Post['fragenBearbeiten'])){
    $fragebogenView->showFragenVonFragebogen($_POST['fragebogenBearbeiten']);
    echo  '<input type="submit" name="frageLoeschen" value="Frage löschen" />';
}
?>



</html>

<?php

// Fragebogen hinzufügen
if (isset($_POST['fragenhinzufuegen'])) {
    $kuerzel = $fragebogenCon->kuerzelVonFragebogen($titelFragebogen);
    $i = 1;
    while ($i <= $_SESSION["AnzahlFragenSession"]) {
        $titelFrage = $_POST["inhaltFrage' . $i . '"];
        //Prüfen, ob Feld "Fragebogen" leer ist
        if (empty($frage)) {
            header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?s=empty");
            exit();
        } else {
            //Prüfen, ob Frage schon existiert
            if ($fragebogenCon->checkFrage($titelFrage, $kuerzel) != false) {
                header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?s=nosuccess");
                exit();
            } else {
                $fragebogenCon->createFrage($titelFrage, $kuerzel);
                header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?s=success");
                exit();
            }
        }
        $i++;
    }
}
    
if (!isset($_GET['s'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    //Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
    $frageAnlegen = $_GET['s'];
    //Then we check if the GET value is equal to a specific string
    if ($frageAnlegen == "empty") {
        //If it is we create an error or success message!
        echo "<p class='error'>Bitte füllen Sie das Feld aus!</p>";
        exit();
    } elseif ($frageAnlegen == "nosuccess") {
        echo "<p class='error'>Diese Frage existiert bereits!</p>";
        exit();
    } elseif ($frageAnlegen == "success") {
        echo "<p class='success'>Sie haben die Frage/n erfolgreich angelegt!</p>";
        exit();
    }
} 