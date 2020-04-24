<?php
//session_start();


include_once 'classes/dbh.class.php';

$frageObject = new FragebogenView();
$freischaltenObj = new fragebogenController();
$benutzerObject = new KursView();





session_start();
//Input-Felder Fragebogen Anlegen laden
$_SESSION["AnzahlFragenSession"] = 0;
if (isset($_POST['fragebogenAnlegen'])) {
    $_SESSION["AnzahlFragenSession"] = $_POST['anzahlFragen'];
}

//Fragebogen Freigeben
if (isset($_POST['freigeben'])) {
    $freischaltenObj->fragebogenFreischalten($_POST['fragebogen'], $_POST['kurses']);
}


?>
<html>
<h4>Fragebogen anlegen</h4>
<?php
// Eingabe des Titels und der Anzahl der Felder 
?>
<form action="" method="post">
    <label for="TitelFragebogen">Titel Fragebogen:</label>
    <input type="text" name="titel"> <br><br>
    <label for="AnzahlFragen">Anzahl Fragen:</label>
    <input type="text" name="anzahlFragen">
    <input type="submit" name="fragebogenAnlegen" value="Fragebogen anlegen" /><br>
</form>
<form action="" method="post">
    <?php

    // Input-Felder erstellen nach Anzahl der gewünschten Fragen. 
    $i = 1;
    while ($i <= $_SESSION["AnzahlFragenSession"]) {
        echo '<label for="inhaltFrage"> Frage ' . $i . '</label>';
        echo '<input type="text" name="inhaltFrage' . $i . '"></br>';
        $i++;
    }
    ?>
</form>
<?php

//Wenn mindestens eine Frage erstellt werden kann, kann der Fragebogen erstellt und abgeschlossen werden.
if ($_SESSION['AnzahlFragenSession'] >= 1) {
    echo '<form action="" method="post">
<input type="submit" name="fragenhinzufuegen" value="Frage/n hinzufügen" /><br>
</form>';
}
?>

<h4>Fragebogen freigeben</h4>
<form action="" method="post" >
    <select name="fragebogen">
        <?php
        $frageObject->showFragebogenVonBenutzer('user1');
        ?>
    </select>

    <select name="kurses">
        <?php
        $benutzerObject->showKursesfromBenutzer('user1');
        ?>
    </select>
    <input type="submit" name="freigeben" value="Fragebogen freigeben" />

</form>

<h4>Fragebogen bearbeiten</h4>
<form action="" method="post">
    <select name="fragebogenBearbeiten">
        <?php
        $frageObject->showFragebogenVonBenutzer('user1');
        ?>
    </select>
    <input type="submit" name="fragenBearbeiten" value="Fragebogen bearbeiten" />
</form>
    <?php
    //ToDO
    //Frage löschen
    //echo $_POST['fragebogenBearbeiten'];
    if(isset($_Post['fragenBearbeiten'])){
        $frageObject->showFragenVonFragebogen($_POST['fragebogenBearbeiten']);
        echo  '<input type="submit" name="frageLoeschen" value="Frage löschen" />';
    }
    ?>

    <br><br><br>
    <input type="submit" name="kopieren" value="Fragebogen kopieren"/>
    <input type="submit" name="loeschen" value="Fragebogen loeschen"/><br>


</html>





<?php

/* $fragebogenObj = new fragebogenController();
    if(isset($_POST['fragebogenAnlegen'])){
        $fragebogen = $_POST['titel'];
        $anzahlFragen = $_POST['AnzahlFragen'];
        $benutzername = $_SESSION['Benutzername'];
        //Prüfen, ob Feld "Fragebogen" leer ist
        if ((empty($fragebogen)) or (empty($anzahlFragen))) {
            header("Location: ../DB2__NK_PHP/indexFragebogen1.php?k=empty");
            exit();
        } else {
            // Prüfen, ob AnzahlFragen richtig ausgefüllt wurde
            if ((!preg_match("/[0-9]/", $anzahlFragen)) and ($anzahlFragen <= 20)) {
                header("Location: ../DB2__NK_PHP/indexFragebogen1.php?k=char");
                exit();
            }
            //Prüfen, ob Fragebogen schon existiert
            if ($fragebogenObj->checkFragebogen($fragebogen) != false) {
                header("Location: ../DB2__NK_PHP/indexFragebogen1.php?k=nosuccess");
                exit();
            } else {
                $fragebogenObj->createFragebogen($fragebogen, $benutzername);
                header("Location: ../DB2__NK_PHP/indexFragebogen1.php?k=success");
                exit();
            }
        }
    }
        
    if (!isset($_GET['k'])) {
        //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
    } else {
        //Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
        $fragebogenErstellen = $_GET['k'];
        //Then we check if the GET value is equal to a specific string
        if ($fragebogenErstellen == "empty") {
            //If it is we create an error or success message!
            echo "<p class='error'>Bitte füllen Sie das Feld aus!</p>";
            exit();
        } elseif ($fragebogenErstellen == "char") {
            echo "<p class='error'>Bitte füllen Sie das Feld mit Zahlenwerten aus!</p>";
            exit();
        } elseif ($fragebogenErstellen == "nosuccess") {
            echo "<p class='error'>Diesen Fragebogen gibt es schon!</p>";
            exit();
        } elseif ($fragebogenErstellen == "success") {
            header("Location: ../DB2__NK_PHP/indexFrage1.php");
            // echo "<p class='success'>Sie haben den Fragebogen erfolgreich erstellt.!</p>";
            exit();
        }
    } */

?>