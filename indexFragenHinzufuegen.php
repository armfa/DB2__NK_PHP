<?php

include_once 'classes/dbh.class.php';

$fragebogenObj = new Fragebogen();

if (!isset($_GET['anzahlFragen']) AND !isset($_GET['kuerzel'])){
    echo "Error";
    exit;
}

$anzahlFragen = $_GET['anzahlFragen'];
$kuerzel = $_GET['kuerzel'];

// Input-Felder erstellen nach Anzahl der gewünschten Fragen. 
$i = 1;
while($i <= $anzahlFragen){
    echo '<form action="" method="POST">
    <label for="inhaltFrage"> Frage '.$i.'</label>
    <input type="text" name="inhaltFragen[]'.$i.'"></br><br>';
    $i++;
}


//Wenn mindestens eine Frage erstellt werden kann, kann der Fragebogen erstellt und abgeschlossen werden.
if ($anzahlFragen >= 1) {
    echo '<input type="submit" name="fragenHinzufuegen" value="Frage/n hinzufügen" /><br>
    </form>';
}
?>

</html>

<?php

// Fragen hinzufügen
if (isset($_POST['fragenHinzufuegen'])) {
    if(count($inhaltFragenArray[]) == $anzahlFragen){
        for($z = 0; $z <= $anzahlFragen; $z++){
            //Prüfen, ob Feld "Frage" leer ist
            if (empty($_POST["inhaltFrage'.$z.'"])) {
                header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?s=empty");
                exit();
            } else {
                $inhaltFrage = $_POST["inhaltFrage'.$z.'"];
                //Prüfen, ob Frage schon existiert
                if ($fragebogenObj->checkObFrageExistiert($titelFrage, $kuerzel) != false) {
                    header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?s=nosuccess");
                    exit();
                } else {
                    $fragebogenObj->setFrage($inhaltFrage, $kuerzel);
                    header("Location: ../DB2__NK_PHP/indexFragenHinzufuegen.php?s=success");
                    exit();
                }
            }
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

