<?php
//session_start();


include_once 'classes/dbh.class.php';

$fragebogenView = new FragebogenView();
$fragebogenCon = new FragebogenController();
$kursView = new KursView();

session_start();
//Input-Felder Fragebogen Anlegen laden

?>

<html>
<h4>Fragebogen anlegen</h4>

<form action="" method="post">
    <label for="TitelFragebogen">Titel Fragebogen:</label>
    <input type="text" name="titel"> <br><br>
    <label for="AnzahlFragen">Anzahl Fragen:</label>
    <input type="text" name="anzahlFragen">
    <input type="submit" name="fragebogenAnlegen" value="Fragebogen anlegen" /><br>
</form>

<h4>Fragebogen freigeben</h4>
<form action="" method="post" >
    <select name="fragebogen">
        <?php
        $fragebogenView->showFragebogenVonBenutzer('user1');
        ?>
    </select>

    <select name="kurse">
        <?php
        $kursView->showKursesfromBenutzer('user1');
        ?>
    </select>
    <input type="submit" name="freigeben" value="Fragebogen freigeben" />
</form>

<h4>Fragebogen bearbeiten</h4>
<form action="" method="post">
    <select name="fragebogenBearbeiten">
        <?php
        $fragebogenView->showFragebogenVonBenutzer('user1');
        ?>
    </select>
    <input type="submit" name="fragenBearbeiten" value="Frage/n löschen/hinzufügen" />
    <input type="submit" name="kopieren" value="Fragebogen kopieren"/>
    <input type="submit" name="loeschen" value="Fragebogen loeschen"/><br>
</form>
</html>

<?php

// Fragebogen anlegen
if (isset($_POST['fragebogenAnlegen'])) {
    $fragebogen = $_POST['titel'];
    $benutzername = 'user1';
    $anzahlFragen = $_POST['anzahlFragen'];
    //Prüfen, ob Feld "Fragebogen" leer ist
    if ((empty($fragebogen)) or (empty($anzahlFragen))) {
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?k=empty");
        exit();
    } else {
        // Prüfen, ob AnzahlFragen richtig ausgefüllt wurde
        if ((!preg_match("/[0-9]/", $anzahlFragen)) and ($anzahlFragen <= 20)) {
            header("Location: ../DB2__NK_PHP/indexFragebogen.php?k=char");
            exit();
        }
        //Prüfen, ob Fragebogen schon existiert
        if ($fragebogenCon->checkFragebogen($fragebogen) != false) {
            header("Location: ../DB2__NK_PHP/indexFragebogen.php?k=nosuccess");
            exit();
        } else {
            $fragebogenCon->createFragebogen($fragebogen, $benutzername);
            header("Location: ../DB2__NK_PHP/indexFragebogen.php?k=success");
            header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php");
            exit();
        }
    }
}
       
if (!isset($_GET['k'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    //Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
    $fragebogenAnlegen = $_GET['k'];
    //Then we check if the GET value is equal to a specific string
    if ($fragebogenAnlegen == "empty") {
        //If it is we create an error or success message!
        echo "<p class='error'>Bitte füllen Sie das Feld aus!</p>";
        exit();
    } elseif ($fragebogenAnlegen == "char") {
        echo "<p class='error'>Bitte füllen Sie das Feld mit Zahlenwerten aus!</p>";
        exit();
    } elseif ($fragebogenAnlegen == "nosuccess") {
        echo "<p class='error'>Dieser Fragebogen existiert bereits!</p>";
        exit();
    } elseif ($fragebogenAnlegen == "success") {
        echo "<p class='success'>Sie haben den Fragebogen erfolgreich angelegt!</p>";
        exit();
    }
}

//Fragebogen Freigeben
if (isset($_POST['freigeben'])) {
    $kuerzel = $_POST['fragebogen'];
    $kursname = $_POST['kurse'];
    //Prüfen, ob Fragebogen bereits dem Kurs freigegeben wurde
    if ($fragebogenCon->checkFreigabe($kuerzel, $kursname) != false) {
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?t=nosuccess");
        exit();
    } else {
        $fragebogenCon->fragebogenFreischalten($kuerzel, $kursname);
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?t=success");
        exit();
    }
}
       
if (!isset($_GET['t'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    //Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
    $fragebogenAnlegen = $_GET['t'];
    //Then we check if the GET value is equal to a specific string
    if ($fragebogenAnlegen == "nosuccess") {
        echo "<p class='error'>Diese Freigabe existiert bereits!</p>";
        exit();
    } elseif ($fragebogenAnlegen == "success") {
        echo "<p class='success'>Sie haben den Fragebogen erfolgreich freigegeben!</p>";
        exit();
    }
}

//Fragebogen Löschen
if (isset($_POST['loeschen'])) {
    $kuerzel = $_POST['fragebogenBearbeiten'];
    $fragebogenCon->deleteFragebogen($kuerzel);
    header("Location: ../DB2__NK_PHP/indexFragebogen.php?u=success");
    exit();
}

if (!isset($_GET['u'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    //Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
    $fragebogenAnlegen = $_GET['u'];
    //Then we check if the GET value is equal to a specific string
    if ($fragebogenAnlegen == "success") {
        echo "<p class='success'>Sie haben den Fragebogen erfolgreich gelöscht!</p>";
        exit();
    }
}

if (isset($_POST['kopieren'])){
    $kuerzel = $_POST['fragebogenBearbeiten'];
    echo '<form action="" method="post">
    <input type="text" name="titelFragebogen"> <br>
    <input type="submit" name="umbenennen" value="Fragebogen umbenennem" />
    </form>';
    $fragebogenCon->checkFragebogen($titelFragebogen);
    
    $fragebogenCon->createFragebogen($fragebogen, $benutzername);
    $fragebogenCon->createFrage($inhaltFrage, $kuerzel);

}

?>