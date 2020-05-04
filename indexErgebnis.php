<?php
<<<<<<< HEAD

// Fabrice Armbruster, Dana Geßler
/* 3. Ergebnisdarstellung
=======
    // Dana Geßler
    /* 3. Ergebnisdarstellung
>>>>>>> 493d88d242ad9bc39ffa794d90af98c8b91e1813
Ein Fragebogenerfasser kann einen von ihm freigeschalteten Fragebogen auswählen und über
eine Kursauswahl eine kursweise Auswertung durchführen. Er bekommt zu jeder Frage die
Durchschnitts-, Minimal-, Maximal und Standardabweichungswerte der Antworten als auch eine
Liste aller Kommentare dargestellt. Die Informationen sind über Aufrufe zentrale PHP-Funktionen
(siehe Punkt 4) zu ermitteln. */

<<<<<<< HEAD
include_once 'classes/dbh.class.php';
//Diese Seite akzeptiert nur Benutzer
if (isset($_SESSION['benutzername']) == false) {
    //Falls Benutzer nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
    //Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}



?>
=======
    //Diese Seite akzeptiert nur Benutzer
    if (isset($_SESSION['benutzername']) == false) {
        //Falls Benutzer nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
        //Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
        header("Location: ../DB2__NK_PHP/index.php");
        exit();
    }

    include_once 'classes/dbh.class.php';
>>>>>>> 493d88d242ad9bc39ffa794d90af98c8b91e1813

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
    <h1>Ergbnisdarstellung</h1>

    <label>Welchen Kurs möchten Sie auswerten?</label></br>
    <label>Welchen Fragebogen möchten Sie auswerten?</label></br>

    <h3>Was möchten Sie auswerten?</h3>

    <form class='auswertung' action="" method="post">
        <label>Welchen Kurs möchten Sie auswerten?</label>
        <select name="auswertungKurs">
            <?php
            //Dropdownauswahl des Kurses
            //ToDo: aktueller Benutzer Übergeben     
            $ergbnisObject = new KursView();
            $ergbnisObject->showKursesfromBenutzer($_SESSION['benutzername']);
            ?>
        </select></br>
        <label>Welchen Fragebogen möchten Sie auswerten?</label>
        <select name="fragebogen">
            <?php
            //Dropdownauswahl des fragebogens
            //ToDo: aktueller Benutzer Übergeben     
            $ergebnisVObject = new ErgebnisView();

            $Kurs = $_POST['auswertungKurs'];
            $Fragebogen = $_POST['fragebogen'];

            if (isset($_POST["fragebogenAuswerten"])) {
                $Kommentare =  $ergebnisVObject->showKommentare($Fragebogen, $Kurs);
                $ErgebnisArray =  $ergebnisVObject->showBerechnungenJeFragejeKurs($Fragebogen, $Kurs);
                header("Location: ../DB2__NK_PHP/indexErgebnis.php?ergebnis=kursergebnisse");
            }

            if (!isset($_GET['ergebnis'])) {
                //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
                exit();
            } else {
                //Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
                $loginstatus = $_GET['ergebnis'];
                if ($loginstatus == "empty") {
<<<<<<< HEAD
                    echo "<p class='success'>Hier sind die Ergebnisse von Kurs </p>".$Kurs;
                    echo "<h2>Ergebnisse: ?</h2>";
                    echo "<h3>Kommentare: ?</h3>".$Kommentare;
                    echo "<h3>Durchschnittliche Antwort: ?</h3>".$ErgebnisArray[0];
                    echo "<h3>Minimale Antwort: ?</h3>".$ErgebnisArray[1];
                    echo "<h3>Maximale Antwort: ?</h3>".$ErgebnisArray[2];
                    echo "<h3>Standardabweichung: ?</h3>".$ErgebnisArray[3];
=======
                    echo "<p class='success'>Hier sind die Ergebnisse von Kurs </p>" . $Kurs;
                    echo "<h3>Kommentare: ?</h3>" . $Kommentare;
                    echo "<h3>Durchschnittliche Antwort: ?</h3>" . $ErgebnisArray[0];
                    echo "<h3>Minimale Antwort: ?</h3>" . $ErgebnisArray[1];
                    echo "<h3>Maximale Antwort: ?</h3>" . $ErgebnisArray[2];
                    echo "<h3>Standardabweichung: ?</h3>" . $ErgebnisArray[3];
>>>>>>> 493d88d242ad9bc39ffa794d90af98c8b91e1813
                    exit();
                }
            }
            ?>
        </select></br>
        <button type="submit" name="fragebogenAuswerten">Fragebogen auswerten</button>
    </form>

</body>

</html>

</body>

</html>