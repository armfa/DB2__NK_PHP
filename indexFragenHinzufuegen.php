<?php

include_once 'classes/dbh.class.php';


session_start();
$_SESSION["AnzahlFragenSession"] = 0;
if (isset($_POST['fragebogenAnlegenStarten'])) {
$_SESSION["AnzahlFragenSession"] = $_POST['anzahlFragen'];
}

$fragebogenCon = new FragebogenController();

?>

<html>

<form  action="" method="post">
<?php

// Input-Felder erstellen nach Anzahl der gewünschten Fragen. 
$i = 1;
while($i <= $_SESSION["AnzahlFragenSession"]){
    echo '<label for="inhaltFrage"> Frage '.$i.'</label>';
    echo '<input type="text" name="inhaltFrage'.$i.'"></br>';
    $i++;
}
?>
</form>	      
<?php

//Wenn mindestens eine Frage erstellt werden kann, kann der Fragebogen erstellt und abgeschlossen werden.
if ($_SESSION['AnzahlFragenSession']>= 1) {
    echo '<form action="" method="post">
<input type="submit" name="fragebogenAnlegen" value="Fragebogen anlegen" /><br>
</form>';
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
            header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?s=empty");
            exit();
        } else {
            //Prüfen, ob Frage schon existiert
            if ($fragebogenCon->checkFrage($titelFrage, $kuerzel) != false) {
                header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?s=nosuccess");
                exit();
            } else {
                $fragebogenCon->createFrage($titelFrage, $kuerzel);
                header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?s=success");
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

?>

