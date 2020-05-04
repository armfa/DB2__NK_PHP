<?php

// Isabelle Scheffler

//______________________KLASSENBESCHREIBUNG______________________
// Diese PHP-Seite ist für das Hinzufügen der Fragen zum Fragebogen zuständig.
// Es werden dafür Funktionen in den Klasse "Fragebogen.class" ausgelagert. 

include_once 'classes/dbh.class.php';

//Diese Seite akzeptiert nur Benutzer
if (!isset($_SESSION['benutzername'])) {
    //Falls Benutzer nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
    //Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}

// Wenn keine "anzahlFragen" und "kuerzel" weitergeben wird, leitet es den Nutzer zurück auf die "indexFragebogen.php" Seite.
if (!isset($_GET['anzahlFragen']) AND !isset($_GET['kuerzel'])){
    header("Location: ../DB2__NK_PHP/indexFragebogen.php");
    exit;
}

$fragebogenObj = new Fragebogen();

// Die übergebenen Werte "anzahlFragen" und "kuerzel" werden hier in der jeweiligen Variable gespeichert.
$anzahlFragen = $_GET['anzahlFragen'];
$kuerzel = $_GET['kuerzel'];
?>

<html>
    
<head>
    <title>Fragen hinzufügen</title>
</head>

<body>
    <header style="background-color:Gray;">
        <!--Link um zurück auf die Fragebogen Seite zu kommen-->
        <br><a href="indexFragebogen.php">Zurück zur Fragebogen-Seite</a><br><br>
    </header>

    <br><br>

    <?php
    // Je nach Anzahl an Fragen die erstellt werden sollen, werden Textfelder erstellt. 
    $i = 1;
    while($i <= $anzahlFragen){
        echo '<form action="" method="POST">
        <label for="inhaltFrage"> Frage '.$i.'</label>
        <input type="text" name="inhaltFragen[]'.$i.'" maxlength="100" required></br><br>';
        $i++;
    }
    ?>


    <input type="submit" name="fragenHinzufuegen" value="Frage/n hinzufügen" /><br>
    </form>
</body>
</html>

<?php
// Fragen hinzufügen
if (isset($_POST['fragenHinzufuegen'])) {
    // Wenn der Button geklickt wurde, wird der Inhalt der Textfelder "inhaltFragen[]" einer Variable zugeordnet.
    $inhaltFragenArray = $_POST["inhaltFragen"];

    if(count($inhaltFragenArray) == $anzahlFragen){
        for($z = 0; $z < $anzahlFragen; $z++){
            $inhaltFrage = $inhaltFragenArray[$z];
            // Prüfen, ob die Frage im Fragebogen schon existiert.
            if ($fragebogenObj->checkObFrageExistiert($inhaltFrage, $kuerzel)) {
                header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?s=nosuccess&kuerzel=$kuerzel&anzahlFragen=$anzahlFragen");
                exit();
            } else {
                // Wennn nicht, wird die Frage hinzugefügt.
                $fragebogenObj->setFrage($inhaltFrage, $kuerzel);
            }
        }

        header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?s=success&kuerzel=$kuerzel&anzahlFragen=$anzahlFragen");
        exit();

    } else{
        header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?s=wrong&kuerzel=$kuerzel&anzahlFragen=$anzahlFragen");
        exit();
    }
}
   
// Fehlermeldung zu Fragen hinzufügen
if (!isset($_GET['s'])) {
    // Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    // Falls ein GET existiert, wird nach der Zuordnung ausgewertet.
    $frageAnlegen = $_GET['s'];
    // Je nachdem, was für ein Fehler aufgetreten ist oder ob der Vorgang erfolgreich war, wird eine Meldung an der Oberfläche ausgegeben.
    if ($frageAnlegen == "wrong") {
        echo "<p class='error'>Es ist ein Fehler aufgetreten! Bitte versuchen Sie es erneut!</p>";
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

