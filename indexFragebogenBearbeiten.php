<?php

// Isabelle Scheffler

//______________________KLASSENBESCHREIBUNG______________________
// Diese PHP-Seite ist für die Bearbeitung des Fragebogens zuständig.
// Es werden dafür Funktionen in den Klasse "Fragebogen.class" ausgelagert. 

include_once 'classes/dbh.class.php';

// Diese Seite akzeptiert nur Benutzer
if (isset($_SESSION['benutzername']) == false) {
    // Falls Benutzer nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
    // Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}

// Wenn kein "kürzel" weitergeben wird, leitet es den Nutzer zurück auf die "indexFragebogen.php" Seite.
if (!isset($_GET['kuerzel'])){
    header("Location: ../DB2__NK_PHP/indexFragebogen.php");
    exit;
}

$fragebogenObj = new Fragebogen();

// Das übergebene "kuerzel" wird hier in der Variable gespeichert.
$kuerzel = $_GET['kuerzel'];

?>
<!doctype HTML>
<html>
<head>
    <title>Fragebogen Bearbeiten</title>
</head>

<body>

    <!--Link um zurück auf die Startseite zu kommen bzw. Logout-->
    <header style="background-color:lightGray;">
        <ul>
            <li><a href="indexFragebogen.php">Zurück zum Fragebogen</a></li>
            <li><a href="indexLogin.php">Logout</a></li>
        </ul>
    </header>
   
    <h3>Frage hinzufügen</h3>
    <form action="" method="POST">
        <input type="text" name="inhaltFrage" maxlength="100" required>
        <input type="submit" name="frageHinzufuegen" value="Frage hinzufügen" /><br>
    </form>
    <br>

    <h3>Frage löschen</h3>
    <form action="" method="POST">
        <!--Drop-Down Menü das alle Fragen anzeigt, die zu dem zuvor - auf der "indesFragebogen.php" Seite - ausgewählten Fragebogen gehören.-->
        <select name='fragenr'>
            <?php
            $fragenArray = $fragebogenObj->getFragenVonFragebogen($kuerzel);
            $i = 0;
            while($i < count($fragenArray)){
                echo "<option value='" . $fragenArray[$i]['Fragenummer'] . "'>" . $fragenArray[$i]['InhaltFrage'] . "</option>";
                $i++;
            } 
            ?>
        </select>

        <input type="submit" name="frageLoeschen" value="Frage löschen" />
    </form>
</body>

<?php
// Frage hinzufügen
if (isset($_POST['frageHinzufuegen'])) {
    // Wenn der Button geklickt wurde, wird das Textfeld "inhaltFrage" einer Variable zugeordnet.
    $inhaltFrage = $_POST["inhaltFrage"];
    // Prüfen, ob das Textfeld leer ist.
    if (empty($inhaltFrage)) {
        header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?login=empty");
        exit();
    }
    // Prüfen, ob die Frage im Fragebogen schon existiert.
    elseif ($fragebogenObj->checkObFrageExistiert($inhaltFrage, $kuerzel)) {
        header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?s=nosuccess&kuerzel=$kuerzel");
        exit();
    } 
    else {
        // Die Frage wird dem Fragebogen hinzugefügt.
        $fragebogenObj->setFrage($inhaltFrage, $kuerzel);
        header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?s=success&kuerzel=$kuerzel");
        exit();
    }
}
    
// Fehlermeldung zu Frage hinzufügen
if (!isset($_GET['s'])) {
    // Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else { 
    // Falls ein GET existiert, wird nach der Zuordnung ausgewertet.
    $frageHinzufuegen = $_GET['s'];
    // Je nachdem, was für ein Fehler aufgetreten ist oder ob der Vorgang erfolgreich war, wird eine Meldung an der Oberfläche ausgegeben.
    if ($frageHinzufuegen == "empty") {
        echo "<p class='error'>Bitte füllen Sie das Textfeld aus!</p>";
    } elseif ($frageHinzufuegen == "nosuccess") {
        echo "<p class='error'>Diese Frage existiert bereits!</p>";
    } elseif ($frageHinzufuegen == "success") {
        echo "<p class='success'>Sie haben die Frage/n erfolgreich angelegt!</p>";
    }
} 

// Frage löschen
if (isset($_POST['frageLoeschen'])) {
    // Die im Drop-Down Menü ausgewählte Frage wird gelöscht.
    $fragenummer = $_POST["fragenr"];
    // Prüfen, ob der Frage bereits in Bearbeitung ist.
    if($fragebogenObj->checkObFrageInBefragung($fragenummer) != false){
        header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?u=nosuccess&kuerzel=$kuerzel");
        exit();
    } else{
        $fragebogenObj->deleteFrage($fragenummer);
        header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?u=success&kuerzel=$kuerzel");
        exit();
    }
}
  
// Fehlermeldung zu Frage löschen
if (!isset($_GET['u'])) {
    // Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else { 
    // Falls ein GET existiert, wird nach der Zuordnung ausgewertet.
    $frageLoeschen = $_GET['u'];
    // Je nachdem, was für ein Fehler aufgetreten ist oder ob der Vorgang erfolgreich war, wird eine Meldung an der Oberfläche ausgegeben.
    if ($frageLoeschen  == "nosuccess") {
        echo "<p class='success'>Sie können die Frage nicht löschen, da diese bereits in der Bearbeitung durch die Studenten ist!</p>";
    } elseif ($frageLoeschen  == "success") {
        echo "<p class='success'>Sie haben die Frage erfolgreich gelöscht!</p>";
    }
} 
?>
</html>
