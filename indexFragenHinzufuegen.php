<?php

// Isabelle Scheffler

//______________________KLASSENBESCHREIBUNG______________________
// Diese PHP-Seite ist für das Hinzufügen der Fragen zum Fragebogen zuständig.
// Es werden dafür Funktionen in die Klasse "Fragebogen.class.php" ausgelagert. 

include_once 'classes/dbh.class.php';

// Diese Seite akzeptiert nur Benutzer.
if (!isset($_SESSION['benutzername'])) {
    // Falls Benutzer nicht eingeloggt sind, wird dieser auf die index-Seite weitergeleitet.
    // Ist dieser dort auch nicht eingeloggt, wird dieser auf die Login-Seite weitergeleitet.
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}

// Wenn keine "anzahlFragen" und "kuerzel" weitergeben wird, leitet es den Nutzer zurück auf die "indexFragebogen.php" Seite.
if (!isset($_GET['anzahlFragen']) and !isset($_GET['kuerzel'])) {
    header("Location: ../DB2__NK_PHP/indexFragebogen.php");
    exit;
}

$fragebogenObj = new Fragebogen();

// Die übergebenen Werte "anzahlFragen" und "kuerzel" werden hier in der jeweiligen Variable gespeichert.
$anzahlFragen = $_GET['anzahlFragen'];
$kuerzel = $_GET['kuerzel'];
?>
<!doctype HTML>
<html>

<head>
    <title>Fragen hinzufügen</title>
</head>

<body>
    <!--Link um zurück auf die Startseite bzw. Logout zu kommen-->
    <header style="background-color:lightGray;">
        <ul>
            <li><a href="indexFragebogen.php">Zurück zum Fragebogen</a></li>
            <li><a href="indexLogin.php">Logout</a></li>
        </ul>
    </header>

    <br><br>

    <?php
    // Je nach Anzahl an Fragen die erstellt werden sollen, werden Textfelder erstellt. 
    $i = 1;
    while ($i <= $anzahlFragen) {
        echo '<form action="" method="POST">
        <label for="inhaltFrage"> Frage ' . $i . '</label>
        <input type="text" name="inhaltFragen[]' . $i . '" maxlength="100" required></br><br>';
        $i++;
    }
    ?>


    <input type="submit" name="fragenHinzufuegen" value="Frage/n hinzufügen" /><br>
    </form>
</body>

<?php
// Fragen hinzufügen
if (isset($_POST['fragenHinzufuegen'])) {
    // Wenn der Button geklickt wurde, wird der Inhalt der Textfelder "inhaltFragen[]" einer Variable zugeordnet.
    $inhaltFragenArray = $_POST["inhaltFragen"];
    
    if (count($inhaltFragenArray) == $anzahlFragen) {
        for ($z = 0; $z < $anzahlFragen; $z++) {
            $inhaltFrage = $inhaltFragenArray[$z];
            // Prüfen, ob das Textfeld leer ist.
            if (empty($inhaltFrage)) {
                header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?fragenHinzufuegen=empty&kuerzel=$kuerzel&anzahlFragen=$anzahlFragen");
                exit();
            }
            // Prüfen, ob die Frage im Fragebogen schon existiert.
            elseif ($fragebogenObj->checkObFrageExistiert($inhaltFrage, $kuerzel)) {
                header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?fragenHinzufuegen=nosuccess&kuerzel=$kuerzel&anzahlFragen=$anzahlFragen");
                exit();
            } 
            else {
                // Wennn nicht, wird die Frage hinzugefügt.
                $fragebogenObj->setFrage($inhaltFrage, $kuerzel);
            }
        }
        // Wenn die Fragen erfolgreich hinzugefügt wurden, wird eine Meldung ausgegeben.
        header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?fragenHinzufuegen=success&kuerzel=$kuerzel&anzahlFragen=$anzahlFragen");
        exit();
    } else {
        // Wenn die Länge des Arrays nicht der Anzahl der Fragen entspricht, wird einer Fehlermeldung ausgegeben.
        header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?fragenHinzufuegen=wrong&kuerzel=$kuerzel&anzahlFragen=$anzahlFragen");
        exit();
    }
}

// Fehlermeldung zu Fragen hinzufügen
if (!isset($_GET['fragenHinzufuegen'])) {
    // Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    // Falls ein GET existiert, wird nach der Zuordnung ausgewertet.
    $frageAnlegen = $_GET['fragenHinzufuegen'];
    // Je nachdem, was für ein Fehler aufgetreten ist oder ob der Vorgang erfolgreich war, wird eine Meldung an der Oberfläche ausgegeben.
    if ($frageAnlegen == "empty") {
        echo "<p class='error'>Bitte füllen Sie die Textfelder aus!</p>";
    } elseif ($frageAnlegen == "wrong") {
        echo "<p class='error'>Es ist ein Fehler aufgetreten! Bitte versuchen Sie es erneut!</p>";
    } elseif ($frageAnlegen == "nosuccess") {
        echo "<p class='error'>Diese Frage existiert bereits!</p>";
    } elseif ($frageAnlegen == "success") {
        echo "<p class='success'>Sie haben die Frage/n erfolgreich angelegt!</p>";
    }
}

?>
</html>
