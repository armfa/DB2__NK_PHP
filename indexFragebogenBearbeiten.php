<?php

// Isabelle Scheffler

//______________________KLASSENBESCHREIBUNG______________________
// Diese PHP-Seite ist für die Bearbeitung des Fragebogens insbesondere Fragen löschen und hinzufügen zuständig.
// Es werden dafür Funktionen in die Klasse "Fragebogen.class.php" ausgelagert. 

include_once 'classes/dbh.class.php';

// Diese Seite akzeptiert nur Benutzer.
if (isset($_SESSION['benutzername']) == false) {
    // Falls Benutzer nicht eingeloggt sind, wird dieser auf die index-Seite weitergeleitet.
    // Ist dieser dort auch nicht eingeloggt, wird dieser auf die Login-Seite weitergeleitet.
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}

// Wenn kein "kürzel" weitergeben wird, leitet es den Nutzer zurück auf die "indexFragebogen.php" Seite.
if (!isset($_SESSION['kuerzel'])){
    header("Location: ../DB2__NK_PHP/indexFragebogen.php");
    exit;
}

$fragebogenObj = new Fragebogen();

?>
<!doctype HTML>
<html>
<head>
    <title>Fragebogen Bearbeiten</title>
</head>

<body>

    <!--Link um zurück auf die Startseite  bzw. Logout zu kommen-->
    <header style="background-color:lightGray;">
        <ul>
            <li><a href="indexFragebogen.php">Zurück zum Fragebogen</a></li>
            <li><a href="indexLogin.php">Logout</a></li>
        </ul>
    </header>
   
    <h3>Frage löschen</h3>
    <form action="" method="POST">
        <!--Drop-Down Menü das alle Fragen anzeigt, die zu dem zuvor - auf der "indexFragebogen.php" Seite - ausgewählten Fragebogen gehören.-->
        <select name='fragen'>

        <?php
        $fragenArray = $fragebogenObj->getFragenVonFragebogen($_SESSION['kuerzel']);
            
        $i = 0;
        while($i < count($fragenArray)){
            echo "<option value='".$fragenArray[$i]['Fragenummer']."'>".$fragenArray[$i]['InhaltFrage']."</option>";
            $i++;
        } 
        ?>
        </select>
        <!--Submit-Button um die Fragen eines Fragebogens zu löschen. Wenn noch kein Fragen des Fragebogens existiert oder der Fragebogen bereits in Bearbeitung ist, kann der Submit-Button nicht gedrückt werden.-->
        <input type="submit" name="frageLoeschen" value="Frage löschen" <?php if(($fragebogenObj->checkObFragebogenInBefragung($_SESSION['kuerzel']) == true) or (count($fragenArray) == null)) echo $disabled='disabled';?> />
        <br>
        <h5>Wenn der Button ausgegraut ist, befindet sich der Fragebogen in Bearbeitung durch die Studenten.</h5>
    </form>
    <br>

    <h3>Frage hinzufügen</h3>
    <form action="" method="POST">
        <!--Textfeld, um den Inhalt einer Frage eingeben zu können.-->
        <input type="text" name="inhaltFrage" maxlength="100" required>
        <input type="submit" name="frageHinzufuegen" value="Frage hinzufügen" /><br>
    </form>

</body>

<?php
// Frage löschen
if (isset($_POST['frageLoeschen'])) {
    // Die im Drop-Down Menü ausgewählte Frage wird gelöscht.
    $fragenummer = $_POST["fragen"];
    // Fragen die ausgewählt werden können, können immer gelöscht werden.
    $fragebogenObj->deleteFrage($fragenummer);
    header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?frageLoeschen=success");
    exit();
}
  
// Fehlermeldung zu Frage löschen
if (!isset($_GET['frageLoeschen'])) {
    // Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else { 
    // Falls ein GET existiert, wird nach der Zuordnung ausgewertet.
    $frageLoeschen = $_GET['frageLoeschen'];
    // Es wird eine Meldung an der Oberfläche ausgegeben.
    if ($frageLoeschen  == "success") {
        echo "<p class='success'>Sie haben die Frage erfolgreich gelöscht!</p>";
    }
} 

// Frage hinzufügen
if (isset($_POST['frageHinzufuegen'])) {
    // Wenn der Button geklickt wurde, wird das Textfeld "inhaltFrage" einer Variable zugeordnet.
    $inhaltFrage = htmlspecialchars($_POST["inhaltFrage"], ENT_QUOTES, 'UTF-8');
    // Prüfen, ob das Textfeld leer ist.
    if (empty($inhaltFrage)) {
        header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?frageHinzufuegen=empty");
        exit();
    }
    // Prüfen, ob die Frage im Fragebogen schon existiert.
    elseif ($fragebogenObj->checkObFrageExistiert($inhaltFrage, $_SESSION['kuerzel'])) {
        header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?frageHinzufuegen=nosuccess");
        exit();
    } 
    else {
        // Die Frage wird dem Fragebogen hinzugefügt.
        $fragebogenObj->setFrage($inhaltFrage, $_SESSION['kuerzel']);
        header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?frageHinzufuegen=success");
        exit();
    }
}
    
// Fehlermeldung zu Frage hinzufügen
if (!isset($_GET['frageHinzufuegen'])) {
    // Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else { 
    // Falls ein GET existiert, wird nach der Zuordnung ausgewertet.
    $frageHinzufuegen = $_GET['frageHinzufuegen'];
    // Je nachdem, was für ein Fehler aufgetreten ist oder ob der Vorgang erfolgreich war, wird eine Meldung an der Oberfläche ausgegeben.
    if ($frageHinzufuegen == "empty") {
        echo "<p class='error'>Bitte füllen Sie das Textfeld aus!</p>";
    } elseif ($frageHinzufuegen == "nosuccess") {
        echo "<p class='error'>Diese Frage existiert bereits!</p>";
    } elseif ($frageHinzufuegen == "success") {
        echo "<p class='success'>Sie haben die Frage/n erfolgreich angelegt!</p>";
    }
} 
?>
</html>
