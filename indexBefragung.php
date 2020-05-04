<?php
//Fabrice Armbruster

//______________________KLASSENBESCHREIBUNG______________________
//Diese PHP-Seite ist für die Darstellung der Befragung bzw. Durchführung einer Umfrage zuständig.
//Es werden dafür Funktionen in den Klassen "Befragungsview", "BefragungsController" und "Befragung.class" ausgelagert. 
//Zudem wird die durchgeführte Umfrage auf der Seite indexBefragungVorauswahl.php ausgewählt.

include_once 'classes/dbh.class.php';

//Diese Seite akzeptiert nur Studenten
if (isset($_SESSION['matrikelnummer']) == false) {
    //Falls Student nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
    //Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}

//Initialisierung der Befragungsklasen -->ToDo: in Sessions speichern/ nach Anmeldung initialiseren, sodass Sie nicht jedes mal neu initialisert werden. 
$befragung = new Befragung();
$befragungC = new BefragungController();

$infoMessage = "";

//Fragebogenkürzel von Vorauswahl-Seite wird geholt.
//Wird die URL im Browser neu geladen, gelangt der Benutzer an Seite de 1 des Fragebogens zurück. 
if (isset($_POST['fragebogen'])) {
    $_SESSION["kuerzel"] = $_POST['fragebogen'];
}

//Erste Seite - erster Seitenaufruf
if ((isset($_POST['naechsteFrage']) == false) && (isset($_POST['vorherigeFrage']) == false)) {
    //Alle Fragen werden geholt und in Session gespeichert. 
    $_SESSION["Fragen"] = $befragungsobjekt->getFragenStmt($_SESSION["kuerzel"]);
    $_SESSION["aktuelleSeite"] = 1;
    //Anzahl der Seiten ist die Anzahl der Fragen + Seite Kommentar + Seite fragebogen abschließen. 
    $_SESSION["anzahlSeiten"] = 2 + $befragungsobjekt->getAnzahlFragenFragebogenStmt($_SESSION["kuerzel"])[0];
}

//Nächste Frage-Button 
if (isset($_POST['naechsteFrage'])) {
    //Check, ob es vorletzte Frage ist 
    if ($_SESSION["aktuelleSeite"] == ($_SESSION["anzahlSeiten"] - 1)) {
        //Falls ja, wird der Kommentar in DB gespeichert oder geupdated
        $kommentar = $_POST['kommentar'];
        $befragungC->createOrUpdateKommentarStmt($_SESSION["kuerzel"], $_SESSION['matrikelnummer'], $kommentar);
        //Aktuelle Seite um 1 erhöhen.
        $_SESSION["aktuelleSeite"]++;
    }
    //Check, ob Antwort abgegeben wurde
    if (isset($_POST['Antwort'])) {
        //Falls ja, wird die Antwort in DB gespeichert oder geupdated
        $antwort = $_POST['Antwort'];
        $Fragenummer = $_SESSION["Fragen"][$_SESSION["aktuelleSeite"] - 1]["Fragenummer"];
        $befragungC->createOrUpdateFrageAntwortStmt($Fragenummer, $_SESSION["kuerzel"], $_SESSION['matrikelnummer'], $antwort);
        //Aktuelle Seite um 1 erhöhen
        $_SESSION["aktuelleSeite"]++;
    }

    //keine Antwort wurde abgegeben -> Nachricht an Benutzer + Benutzer bleibt auf gleicher Seite
    if (isset($_POST['Antwort']) == false && $_SESSION["aktuelleSeite"] - 1 < ($_SESSION["anzahlSeiten"] - 1)) {
        $infoMessage =  "<p class='error'>Bitte wählen Sie eine Antwort aus um zur nächsten Frage zu kommen!</p>";
    }
}

//Vorheriger Frage-Button
if (isset($_POST['vorherigeFrage'])) {
    //Check, ob es vorletzte Frage ist 
    if ($_SESSION["aktuelleSeite"] == ($_SESSION["anzahlSeiten"] - 1)) {
        //Falls ja, wird der Kommentar in DB gespeichert oder geupdated
        $kommentar = $_POST['kommentar'];
        $befragungC->createOrUpdateKommentarStmt($_SESSION["kuerzel"], $_SESSION['matrikelnummer'], $kommentar);
    }
    //Check, ob Antwort abgegeben wurde
    if (isset($_POST['Antwort'])) {
        //Falls ja, wird die Antwort in DB gespeichert oder geupdated
        $antwort = $_POST['Antwort'];
        $Fragenummer = $_SESSION["Fragen"][$_SESSION["aktuelleSeite"] - 1]["Fragenummer"];
        $befragungC->createOrUpdateFrageAntwortStmt($Fragenummer, $_SESSION["kuerzel"], $_SESSION['matrikelnummer'], $antwort);
    }
    //Aktuelle Seite um 1 verringern
    $_SESSION["aktuelleSeite"]--;
}

//Kommentar in db speichern und Fragebogen als abgeschlossen markieren
if (isset($_POST['fragebogenFertig'])) {
    $befragungC->createKommentarFragebogenFertig($_SESSION["kuerzel"], $_SESSION['matrikelnummer'], 1, $_POST['kommentar']);
}

//Abgegebene Antworten aus DB laden
if ($_SESSION["aktuelleSeite"] < ($_SESSION["anzahlSeiten"] - 1)) {
    //Prüfen, ob Frage schon beantwortet
    //Fragenummer holen
    $Fragenummer = $befragungC->showFragenummerStmt($_SESSION["kuerzel"], $_SESSION["Fragen"][$_SESSION["aktuelleSeite"] - 1]['InhaltFrage'])[0]['Fragenummer'];
    //Prüfen, ob schon eine Antwort auf die Frage mit der Fragenummer existiert
    if ($befragungC->showSingleAntwort($Fragenummer, $_SESSION["kuerzel"], $_SESSION['matrikelnummer'])) {
        //Falls ja, dann lade diese in die Check Variable. 
        $check = $befragungsobjekt->getFrageAntwortStmt($_SESSION["kuerzel"], $_SESSION['matrikelnummer'])[$_SESSION["aktuelleSeite"] - 1]['Antwort'];
    } else {
        //Falls nicht, dann ist check leer. 
        $check = "";
    }
    switch ($check) {
        case 1:
            $check1 = "checked";
            $check2 = $check3 =  $check4 = $check5 = "";
            break;
        case 2:
            $check2 = "checked";
            $check1 = $check3 =  $check4 = $check5 = "";
            break;
        case 3:
            $check3 = "checked";
            $check1 = $check2 =  $check4 = $check5 = "";
            break;
        case 4:
            $check4 = "checked";
            $check1 = $check2 =  $check3 = $check5 = "";
            break;
        case 5:
            $check5 = "checked";
            $check1 = $check2 =  $check3 = $check4 = "";
            break;
        default:
            $check1 = $check2 =  $check3 = $check4 = $check5 = "";
    }
}
if ($_SESSION["aktuelleSeite"] == ($_SESSION["anzahlSeiten"]) - 1) {
    //Prüfen, ob kommentar schon vorhanden
    if ($befragungsobjekt->getSingleKommentar($_SESSION["kuerzel"], $_SESSION['matrikelnummer'])) {
        //Falls ja, dann aus DB holen
        $kommentarPreloaded = $befragungsobjekt->getSingleKommentar($_SESSION["kuerzel"], $_SESSION['matrikelnummer'])['Kommentar'];
    } else {
        $kommentarPreloaded = "";
    };
}
?>
<!doctype HTML>
<html>

<!--Link um zurück auf die Startseite zu kommen bzw. Logout-->
<header style="background-color:lightGray;">
    <ul>
        <li><a href="index.php">Zurück zur Startseite</a></li>
        <li><a href="indexLogin.php">Logout</a></li>
    </ul>
</header>

<body>
    <h1>Fragebogen: <?php echo $befragungsobjekt->getFragebogenTitelStmt($_SESSION["kuerzel"])['Titel']; ?></h1>
    <form action="" method="post">
        <?php
        //ToDo: Erzeugen des Seiteninhalts über Datenbankzugriffe;
        if ($_SESSION["aktuelleSeite"] < ($_SESSION["anzahlSeiten"] - 1)) {
            print_r($_SESSION["Fragen"][$_SESSION["aktuelleSeite"] - 1]["InhaltFrage"]);
        } elseif ($_SESSION["aktuelleSeite"] == ($_SESSION["anzahlSeiten"] - 1)) {
            echo "<p>Wir freuen uns auf Ihren Kommentar!</p></br><textarea name='kommentar' rows='5' cols='70' placeholder='Hier können Sie noch Lob und weitere Kritik äußern. Vielen Dank!'>" . $kommentarPreloaded . "</textarea>";
        } else
        ?>
        <?php if ($_SESSION["aktuelleSeite"] <  ($_SESSION["anzahlSeiten"] - 1)) {
        echo '<fieldset>
            <input type="radio" id="1" name="Antwort" value="1" ' . $check1 . '>
            <label for="1"> sehr gut</label> 
            <input type="radio" id="2" name="Antwort" value="2" ' . $check2 . '>
            <label for="2"> eher gut</label>
            <input type="radio" id="3" name="Antwort" value="3" ' . $check3 . '>
            <label for="3"> ausgeglichen</label> 
            <input type="radio" id="4" name="Antwort" value="4" ' . $check4 . '>
            <label for="4"> eher schlecht</label> 
            <input type="radio" id="5" name="Antwort" value="5" ' . $check5 . '>
            <label for="5"> sehr schlecht</label> 
        </fieldset>';
    }

    //ToDo: Erzeugen des Seiteninhalts über Datenbankzugriffe;
    echo "<div>Inhalt der Seite " . $_SESSION["aktuelleSeite"] . " von " . $_SESSION["anzahlSeiten"] . "</div></br>";
        ?>


        <input type="submit" name="vorherigeFrage" value="Vorherige Frage" <?php
                                                                            if ($_SESSION["aktuelleSeite"] ==  1) {
                                                                                echo " disabled ";
                                                                            }
                                                                            ?>>
        <input type="submit" name="naechsteFrage" value="Nächste Frage" <?php
                                                                        if ($_SESSION["aktuelleSeite"] ==  $_SESSION["anzahlSeiten"]) {
                                                                            echo " disabled ";
                                                                        }
                                                                        ?>>
        <?php

        if ($_SESSION["aktuelleSeite"] ==  $_SESSION["anzahlSeiten"]) {
            echo '<button type="submit" name="fragebogenFertig">Fragebogen abschließen</button>';
        }
        ?>
    </form>

    <?php
    if ($infoMessage != "") {
        echo $infoMessage;
    }

    ?>

</body>


</html>