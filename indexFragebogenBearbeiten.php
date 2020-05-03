<?php

include_once 'classes/dbh.class.php';


//Diese Seite akzeptiert nur Benutzer
if (isset($_SESSION['benutzername']) == false) {
    //Falls Benutzer nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
    //Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}

$fragebogenObj = new Fragebogen();

if (!isset($_GET['kuerzel'])){
    echo "Error";
    exit;
}

$kuerzel = $_GET['kuerzel'];

?>

<h4>Fragebogen bearbeiten</h4>
<h4>Frage löschen</h4>

<form action="" method="POST">
    <select name='fragen'>

    <?php
    $fragenArray = $fragebogenObj->getFragenVonFragebogen($kuerzel);
        
    $i = 0;
    while($i < count($fragenArray)){
        echo "<option value='".$fragenArray[$i]['Fragenummer']."'>".$fragenArray[$i]['InhaltFrage']."</option>";
        $i++;
    } 
    ?>

    <input type="submit" name="frageLoeschen" value="Frage löschen" />
    </select>
</form>

<h4>Frage hinzufügen</h4>
<form action="" method="POST">
    <input type="text" name="inhaltFrage">
    <input type="submit" name="frageHinzufuegen" value="Frage hinzufügen" /><br>
</form>

</html>

<?php

// Frage löschen
if (isset($_POST['frageLoeschen'])) {
    $fragenummer = $_POST["fragen"];
    $fragebogenObj->deleteFrage($fragenummer);
    header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?u=success");
    exit();
}
    
if (!isset($_GET['u'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else { 
    $frageLoeschen = $_GET['u'];
    if ($frageLoeschen  == "success") {
        echo "<p class='success'>Sie haben die Frage erfolgreich gelöscht!</p>";
        exit();
    }
} 



// Frage hinzufügen
if (isset($_POST['frageHinzufuegen'])) {
    $inhaltFrage = $_POST["inhaltFrage"];
    //Prüfen, ob Feld "inhaltFrage" leer ist
    if (empty($inhaltFrage)) {
        header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?s=empty");
        exit();
    } else {
        //Prüfen, ob Frage schon existiert
        if ($fragebogenObj->checkObFrageExistiert($inhaltFrage, $kuerzel) != false) {
            header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?s=nosuccess");
            exit();
        } else {
            $fragebogenObj->setFrage($inhaltFrage, $kuerzel);
            header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?s=success");
            exit();
        }
    }
}
    
if (!isset($_GET['s'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else { 
    $frageAnlegen = $_GET['s'];
    if ($frageAnlegen == "empty") {
        echo "<p class='error'>Bitte füllen Sie das Feld aus!</p>";
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