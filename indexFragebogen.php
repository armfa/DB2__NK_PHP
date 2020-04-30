<?php
//session_start();


include_once 'classes/dbh.class.php';


$fragebogenObj = new Fragebogen();
$kursView = new KursView();


?>

<html>
<h4>Fragebogen anlegen</h4>

<form action="" method="POST">
    <label for="TitelFragebogen">Titel Fragebogen:</label>
    <input type="text" name="titel"> <br><br>
    <label for="AnzahlFragen">Anzahl Fragen:</label>
    <input type="text" name="anzahlFragen">
    <input type="submit" name="fragebogenAnlegen" value="Fragebogen anlegen" /><br>
</form>

<h4>Fragebogen freigeben</h4>
<form action="" method="POST">
    <select name='fragebogen'>
    <?php
    $titelArray = $fragebogenObj->getFragebogenVonBenutzer('user1');

    $i = 0;
    while($i < count($titelArray)){
        echo "<option value='".$titelArray[$i]['Kuerzel']."'>".$titelArray[$i]['Titel']."</option>";
        $i++;
    }
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
<form action="" method="POST">
    <select name="fragebogenBearbeiten">
        <?php
        $titelArray = $fragebogenObj->getFragebogenVonBenutzer('user1');

        $i = 0;
        while($i < count($titelArray)){
            echo "<option value='".$titelArray[$i]['Kuerzel']."'>".$titelArray[$i]['Titel']."</option>";
            $i++;
        }
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
    $titelFragebogen = $_POST['titel'];
    $benutzername = 'user1';
    $anzahlFragen = $_POST['anzahlFragen'];
    //Prüfen, ob Feld "Fragebogen" leer ist
    if ((empty($titelFragebogen)) or (empty($anzahlFragen))) {
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?k=empty");
        exit();
    } else {
        // Prüfen, ob AnzahlFragen richtig ausgefüllt wurde
        if ((!preg_match("/[0-9]/", $anzahlFragen)) and ($anzahlFragen <= 20)) {
            header("Location: ../DB2__NK_PHP/indexFragebogen.php?k=char");
            exit();
        }
        //Prüfen, ob Fragebogen schon existiert
        if ($fragebogenObj->checkObFragebogenExistiert($titelFragebogen) != false) {
            header("Location: ../DB2__NK_PHP/indexFragebogen.php?k=nosuccess");
            exit();
        } else {
            $fragebogenObj->setFragebogen($titelFragebogen, $benutzername);
            $kuerzel = $fragebogenObj->getKuerzelVonFragebogen($titelFragebogen);
            header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?kuerzel=$kuerzel&anzahlFragen=$anzahlFragen");
            exit();
        }
    }
}
       
if (!isset($_GET['k'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else { 
    $fragebogenAnlegen = $_GET['k'];
    if ($fragebogenAnlegen == "empty") {
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
    if ($fragebogenObj->checkObFreischaltungExistiert($kuerzel, $kursname) != false) {
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?t=nosuccess");
        exit();
    } else {
        $fragebogenObj->setFreischaltung($kuerzel, $kursname);
        header("Location: ../DB2__NK_PHP/indexFragebogen.php?t=success");
        exit();
    }
}
       
if (!isset($_GET['t'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else { 
    $fragebogenAnlegen = $_GET['t'];
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
    $fragebogenObj->deleteFragebogen($kuerzel);
    header("Location: ../DB2__NK_PHP/indexFragebogen.php?u=success");
    exit();
}

if (!isset($_GET['u'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    $fragebogenAnlegen = $_GET['u'];
    if ($fragebogenAnlegen == "success") {
        echo "<p class='success'>Sie haben den Fragebogen erfolgreich gelöscht!</p>";
        exit();
    }
}

if (isset($_POST['kopieren'])){
    $kuerzel = $_POST['fragebogenBearbeiten'];
    echo '<form action="" method="post">
    <input type="text" name="titelFragebogen"> 
    <input type="submit" name="umbenennen" value="Fragebogen umbenennem" />
    </form>';
    $fragenArray = $fragebogenObj->getFragenVonFragebogen($kuerzel);
    
    if(isset($_POST['umbenennen'])){
        if(empty($titelFragebogen)){
            header("Location: ../DB2__NK_PHP/indexFragebogen.php?s=empty");
            exit();
        } elseif($fragenArray != 0){
            $titelFragebogen = $_POST['titelFragebogen']; 
            $fragebogenObj->setFragebogen($titelFragebogen, $benutzername);
            foreach($frage AS $fragenArray){
                $fragebogenObj->setFrage($frage, $kuerzel);
            }
            header("Location: ../DB2__NK_PHP/indexFragebogen.php?s=success");
            exit();
        }   
    }
}

if (!isset($_GET['s'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    $fragebogenAnlegen = $_GET['s'];
    if ($fragebogenAnlegen == "empty") {
        echo "<p class='error'>Bitte füllen Sie das Feld aus!</p>";
        exit();        
    }elseif ($fragebogenAnlegen == "success") {
        echo "<p class='success'>Sie haben den Fragebogen erfolgreich kopiert!</p>";
        exit();
    }
}

if (isset($_POST['fragenBearbeiten'])){
    $kuerzel = $_POST['fragebogenBearbeiten'];
    header("Location: ../DB2__NK_PHP/indexFragebogenBearbeiten.php?kuerzel=$kuerzel");
}

?>