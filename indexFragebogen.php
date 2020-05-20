<?php

// Isabelle Scheffler

//______________________KLASSENBESCHREIBUNG______________________
// Diese PHP-Seite ist für die Darstellung und Bearbeitung des Fragebogens zuständig.
// Es werden dafür Funktionen in den Klasse "Fragebogen.class" ausgelagert. 
// Zudem wird zu einer neuen Seite weitergeleitet, wenn man die Fragen zu einem Fragebogen hinzufügen will oder man den Fragebogen bearbeiten will.


include_once 'classes/dbh.class.php';

// Diese Seite akzeptiert nur Benutzer
if (!isset($_SESSION['benutzername'])) {
    // Falls Benutzer nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
    // Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}

$fragebogenObj = new Fragebogen();
$kurs = new Kurs();
?>

<!doctype HTML>
<html>

<head>
    <title>Fragebogen</title>
</head>

<body>
    <!--Link um zurück auf die Startseite zu kommen bzw. Logout-->
    <header style="background-color:lightGray;">
        <ul>
            <li><a href="index.php">Zurück zur Startseite</a></li>
            <li><a href="indexLogin.php">Logout</a></li>
        </ul>
    </header>

    <h3>Fragebogen anlegen</h3>
    <form action="" method="POST">
        <label for="TitelFragebogen">Titel Fragebogen:</label>
        <input type="text" name="titel" maxlength="100" required> <br><br>
        <label for="AnzahlFragen">Anzahl Fragen:</label>
        <input type="text" name="anzahlFragen" maxlength="2" required>
        <input type="submit" name="fragebogenAnlegen" value="Fragebogen anlegen" /><br>
    </form>
    <br>

    <h3>Fragebogen freigeben</h3>
    <form action="" method="POST">
        <!--Drop-Down Menü, das alle Fragebögen anzeigt die ein Benutzer angelegt hat.-->
        <select name='fragebogen'>
            <?php
            $fragebogenObj->showFragebogenVonBenutzer($_SESSION['benutzername']);
            ?>
        </select>

        <!--Drop-Down Menü das alle Kurs anzeigt die ein Benutzer angelegt hat.-->
        <select name="kurse">
            <?php
            $kursArray = $kurs->getKurses();
            $i = 0;
            while ($i < count($kursArray)) {
                echo "<option value='" . $kursArray[$i]['Kursname'] . "'>" . $kursArray[$i]['Kursname'] . "</option>";
                $i++;
            }
            ?>
        </select>

        <input type="submit" name="freigeben" value="Fragebogen freigeben" <?php if($fragebogenObj->getFragebogenVonBenutzer($_SESSION['benutzername']) == null) echo $disabled='disabled';?>/>
    </form>
    <br>

    <h3>Fragebogen bearbeiten</h3>
    <form action="" method="POST">
        <!--Drop-Down Menü das alle Fragebögen anzeigt die ein Benutzer angelegt hat.-->
        <select name="fragebogenBearbeiten">
            <?php
            $fragebogenObj->showFragebogenVonBenutzer($_SESSION['benutzername']);
            ?>
        </select>

        <input type="submit" name="fragenLoeschenHinzufuegen" value="Frage/n löschen/hinzufügen" <?php if($fragebogenObj->getFragebogenVonBenutzer($_SESSION['benutzername']) == null) echo $disabled='disabled';?>/>
        <input type="submit" name="loeschen" value="Fragebogen loeschen" <?php if($fragebogenObj->getFragebogenVonBenutzer($_SESSION['benutzername']) == null) echo $disabled='disabled';?> /><br>
    </form>

    <br>
    <h3>Fragebogen kopieren</h3>
    <h5>Die Fragen aus dem linken Fragebogen werden in den rechten Fragebogen kopiert.</h5>
    <form action="" method="POST">
        <!--Drop-Down Menü das alle Fragebögen anzeigt die ein Benutzer angelegt hat.-->
        <select name="fragebogenKopieren1">
            <?php
            $fragebogenObj->showFragebogenVonBenutzer($_SESSION['benutzername']);
            ?>
        </select>

        <!--Drop-Down Menü das alle Fragebögen anzeigt die ein Benutzer angelegt hat.-->
        <select name="fragebogenKopieren2">
            <?php
            $fragebogenObj->showFragebogenVonBenutzer($_SESSION['benutzername']);
            ?>
        </select>

        <input type="submit" name="kopieren" value="Fragebogen kopieren" <?php if($fragebogenObj->getFragebogenVonBenutzer($_SESSION['benutzername']) == null) echo $disabled='disabled';?>/>
    </form>

</body>

<?php

// Fragebogen anlegen
if (isset($_POST['fragebogenAnlegen'])) {
    // Wenn der Button geklickt wurde, werden die Textfelder "titel" und "anzahlFragen" jeweils einer Variable zugeordnet.
    $titelFragebogen = $_POST['titel'];
    $anzahlFragen = $_POST['anzahlFragen'];
    // Prüfen, ob die Textfelder leer sind.
    if (empty($titelFragebogen) || empty($anzahlFragen)) {
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?login=empty");
        exit();
    }
    // Prüfen, ob das Textfeld "anzahlFragen" richtig ausgefüllt wurde.
    elseif ((!preg_match("/[0-9]/", $anzahlFragen)) and ($anzahlFragen <= 20)) {
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?k=char");
        exit();
    }
    // Prüfen, ob der Fragebogen schon existiert.
    elseif ($fragebogenObj->checkObFragebogenExistiert($titelFragebogen) != false) {
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?k=nosuccess");
        exit();
    } 
    else {
        // Existiert der Fragebogen noch nicht, wird dieser erstellt und die Seite "indexFragenHinzufuegen.php" aufgerufen
        // und die Variabelen "kuerzel" und "anzahlFragen" übergeben.
        $fragebogenObj->setFragebogen($titelFragebogen, $_SESSION['benutzername']);
        $kuerzel = $fragebogenObj->getKuerzelVonFragebogen($titelFragebogen);
        header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?kuerzel=$kuerzel&anzahlFragen=$anzahlFragen");
        exit();
    }
}

// Fehlermeldung zu Fragebogen anlegen
if (!isset($_GET['k'])) {
    // Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    //Falls ein GET existiert, wird nach der Zuordnung ausgewertet.
    $fragebogenAnlegen = $_GET['k'];
    // Je nachdem, was für ein Fehler aufgetreten ist oder ob der Vorgang erfolgreich war, wird eine Meldung an der Oberfläche ausgegeben.
    if ($fragebogenAnlegen == "empty") {
        echo "<p class='error'>Bitte füllen Sie die Felder aus!</p>";
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

// Fragebogen freigeben
if (isset($_POST['freigeben'])) {
    // Wenn der Button geklickt wurde, wird die Auswahl der Drop-Down Menüs "fragebogen" und "kurse" jeweils einer Variable zugeordnet.
    $kuerzel = $_POST['fragebogen'];
    $kursname = $_POST['kurse'];
    // Prüfen, ob der Fragebogen bereits für den Kurs freigegeben wurde.
    if ($fragebogenObj->checkObFreischaltungExistiert($kuerzel, $kursname) != false) {
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?t=nosuccess");
        exit();
    } else {
        // Wenn nicht, dann wird der Fragebogen für den Kurs freigegeben.
        $fragebogenObj->setFreischaltung($kuerzel, $kursname);
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?t=success");
        exit();
    }
}

// Fehlermeldung zu Fragebogen freigeben
if (!isset($_GET['t'])) {
    // Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    // Falls ein GET existiert, wird nach der Zuordnung ausgewertet.
    $fragebogenFreigeben = $_GET['t'];
    // Je nachdem, was für ein Fehler aufgetreten ist oder ob der Vorgang erfolgreich war, wird eine Meldung an der Oberfläche ausgegeben.
    if ($fragebogenFreigeben == "nosuccess") {
        echo "<p class='error'>Diese Freigabe existiert bereits!</p>";
        exit();
    } elseif ($fragebogenFreigeben == "success") {
        echo "<p class='success'>Sie haben den Fragebogen erfolgreich freigegeben!</p>";
        exit();
    }
}

// Fragen hinzufügen oder löschen
if (isset($_POST['fragenLoeschenHinzufuegen'])) {
    // Die Auswahl im Drop-Down Menü wird in einer Variable gespeichert.
    $kuerzel = $_POST['fragebogenBearbeiten'];
    // Die Seite "indexFragebogenBearbeiten" wird aufgerufen und die Variable mitgegeben.
    header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?kuerzel=$kuerzel");
}

//Fragebogen Löschen
if (isset($_POST['loeschen'])) {
    // Der im Drop-Down Menü ausgewählte Fragebogen wird gelöscht.
    $kuerzel = $_POST['fragebogenBearbeiten'];
    $fragebogenObj->deleteFragebogen($kuerzel);
    // Hier ist kein Fehlerfall möglich, deshalb ist der Löschvorgang immer erfolgreich.
    header("Location: ../DB2__NK_PHP/indexFragebogen.php?u=success");
    exit();
}

// Fehlermeldung zu Fragebogen löschen
if (!isset($_GET['u'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    //Falls ein GET existiert, wird nach der Zuordnung ausgewertet.
    $fragebogenLoeschen = $_GET['u'];
    // Es wird die Meldung an der Oberfläche ausgegeben.
    if ($fragebogenLoeschen == "success") {
        echo "<p class='success'>Sie haben den Fragebogen erfolgreich gelöscht!</p>";
        exit();
    }
}

// Fragebogen kopieren
if (isset($_POST['kopieren'])) {
    // Die Auswahl im Drop-Down Menü wird in einer Variable gespeichert.
    $fragebogen1 = $_POST['fragebogenKopieren1'];
    $fragebogen2 = $_POST['fragebogenKopieren2'];
    if ($fragebogen1 == $fragebogen2) {
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?s=wrong");
        exit();
    } else {
        // Die Fragen des ausgewählten Fragebogens, werden in ein mehrdimensionales Array gespeichert.
        $fragenArray = $fragebogenObj->getFragenVonFragebogen($fragebogen1);
        print_r($fragenArray);
        // In der ersten Ebene des Arrays steht folgendes -> [0]=>Array
        foreach ($fragenArray as $Index => $Array) {
            // In der zweiten Ebene des Arrays steht folgendes -> [InhaltFrage] => Frage
            foreach ($Array as $InhaltFrageSpalte => $inhaltFrage) {
                // Es ist wird überprüft, ob die Frage schon im Fragebogen existiert, wenn nicht wird sie hinzugefügt.
                if ($fragebogenObj->checkObFrageExistiert($inhaltFrage, $fragebogen2) == 0) {
                    $fragebogenObj->setFrage($inhaltFrage, $fragebogen2);
                }
            }
        }
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?s=success");
        exit();
    }
}

// Fehlermeldung zu Fragebogen kopieren
if (!isset($_GET['s'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    //Falls ein GET existiert, wird nach der Zuordnung ausgewertet.
    $fragebogenKopieren = $_GET['s'];
    // Je nachdem, was für ein Fehler aufgetreten ist oder ob der Vorgang erfolgreich war, wird eine Meldung an der Oberfläche ausgegeben.
    if ($fragebogenKopieren == "wrong") {
        echo "<p class='error'>Bitte wählen Sie verschiedene Fragebögen aus!</p>";
        exit();
    } elseif ($fragebogenKopieren == "nosuccess") {
        echo "<p class='error'>Diese Frage existiert bereits!</p>";
        exit();
    } elseif ($fragebogenKopieren == "success") {
        echo "<p class='success'>Sie haben den Fragebogen erfolgreich kopiert!</p>";
        exit();
    }
}

?> 
</html>
