<?php

// Fabrice Armbruster, Dana Geßler
/* 3. Ergebnisdarstellung
Ein Fragebogenerfasser kann einen von ihm freigeschalteten Fragebogen auswählen und über
eine Kursauswahl eine kursweise Auswertung durchführen. Er bekommt zu jeder Frage die
Durchschnitts-, Minimal-, Maximal und Standardabweichungswerte der Antworten als auch eine
Liste aller Kommentare dargestellt. Die Informationen sind über Aufrufe zentrale PHP-Funktionen
(siehe Punkt 4) zu ermitteln. */

include_once 'classes/dbh.class.php';
//Diese Seite akzeptiert nur Benutzer
if (isset($_SESSION['benutzername']) == false) {
    //Falls Benutzer nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
    //Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}

$auswertungsObj = new Fragebogen();
$kurs = new Kurs();

?>


<!doctype HTML>
<html>

<body>
    <!--Link um zurück auf die Startseite zu kommen bzw. Logout-->
    <header style="background-color:lightGray;">
        <ul>
            <li><a href="index.php">Zurück zur Startseite</a></li>
            <li><a href="indexLogin.php">Logout</a></li>
        </ul>
    </header>

    <h1>Ergbnisdarstellung</h1>

    <h3>Bitte wählen Sie, wie Sie auswerten möchten!</h3>


    <form class='auswertung' action="" method="post">
        <label>Welchen Kurs möchten Sie auswerten?</label>
        <select name="auswertungKurs">
            <?php
            $kursArray = $kurs->getKurses();
            $i = 0;
            while ($i < count($kursArray)) {
                echo "<option value='" . $kursArray[$i]['Kursname'] . "'>" . $kursArray[$i]['Kursname'] . "</option>";
                $i++;
            }
            ?>
        </select>
        </select></br>
        <label>Welchen Fragebogen möchten Sie auswerten?</label>

        <form action="" method="POST">
            <!--Drop-Down Menü, das alle Fragebögen anzeigt die ein Benutzer angelegt hat.-->
            <select name='fragebogen'>
                <?php
                $auswertungsObj->showFragebogenVonBenutzer($_SESSION['benutzername']);
                ?>
            </select>
            <br>
            <br>
            <input type="submit" name="fragebogenAuswerten" value="Fragebogen auswerten" />
        </form>

</body>

<?php
// Fehlermeldung zu Fragebogen freigeben
if (!isset($_GET['fehler'])) {
    // Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    // Falls ein GET existiert, wird nach der Zuordnung ausgewertet.
    $fehler = $_GET['fehler'];
    // Je nachdem, was für ein Fehler aufgetreten ist oder ob der Vorgang erfolgreich war, wird eine Meldung an der Oberfläche ausgegeben.
    if ($fehler == "noComment") {
        echo "<p class='error'>Es existieren keine Kommentare!</p>";
        exit();
    } elseif ($fehler == "noValues") {
        echo "<p class='error'>Es existieren keine beantworteten Fragebögen zur Auswertung!</p>";
        exit();
    }
}
?>
<?php
$ergebnisVObject = new ErgebnisView();


if (isset($_POST["fragebogenAuswerten"])) {
    $Kurs = $_POST['auswertungKurs'];
    $Fragebogen = $_POST['fragebogen'];

    $Kommentare =  $ergebnisVObject->showKommentare($Fragebogen, $Kurs);
    $ergebnisArray =  $ergebnisVObject->structureBerechnungenJeFragejeKurs($Fragebogen, $Kurs);
    echo "<p class='success'>Hier sind die Ergebnisse von Kurs " . $Kurs . ": </p>";
    echo "<h2>Ergebnisse: </h2>";
    echo "<h3>Kommentare:</h3>" . $Kommentare;

    //durchschnittliche Antworten ausgeben
    echo "<h3>Durchschnittliche Antwort:</h3>";

    $ergebnisVObject->displayValues($ergebnisArray, "avgAnswer", $Fragebogen);

    echo "<h3>Minimale Antwort:</h3>";

    $ergebnisVObject->displayValues($ergebnisArray, "minAnswer", $Fragebogen);

    echo "<h3>Maximale Antwort:</h3>";

    $ergebnisVObject->displayValues($ergebnisArray, "maxAnswer", $Fragebogen);

    echo "<h3>Standardabweichung:</h3>";

    $ergebnisVObject->displayValues($ergebnisArray, "standDev", $Fragebogen);
}


//header("Location: ../DB2__NK_PHP/indexErgebnis.php?ergebnis=kursergebnisse");
/*} else {
                $Kurs = $_POST['auswertungKurs'];
                $Fragebogen = $_POST['fragebogen'];
            }*/


//if (!isset($_GET['ergebnis'])) {

//Falls kein GET existiert, wird nichts gemacht und das Skript abgebrochen. 
//exit();
//} else {
//Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
//$ergebnisAngefragt = $_GET['ergebnis'];
//if ($ergebnisAngefragt == "kursergebnisse") {

//exit();
//} elseif ($ergebnisAngefragt == "keineAntworten"){

//}

?>
</select></br>
</form>

</body>

</html>

</body>