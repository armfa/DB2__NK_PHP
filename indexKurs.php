<?php
//Fabrice Armbruster

//Diese Seite akzeptiert nur Benutzer
if (isset($_SESSION['benutzername']) == false) {
    //Falls Benutzer nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
    //Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}

include_once 'classes/dbh.class.php';

$x = new KursView();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kurs</title>
</head>

<body>
    <h1>This is the Kurs Page.</h1>

    <h3>Neuen Kurs anlegen</h3>

    <form class='neuerKurs-form' action="" method="post">
        <input type="text" name="Kurs" placeholder="Kurs">
        <button type="submit" name="kursAnlegen">Kurs anlegen</button>
    </form>
    <h3>Neuen Student anlegen</h3>
    <form class='neuerStudent-form' action="" method="post">
        <label>Kurs</label>
        <select name="kurses">
            <?php
            //Dropdownauswahl des Kurses
            //ToDo: aktueller Benuttzer Übergeben     
            $benutzerObject = new KursView();
            $benutzerObject->showKursesfromBenutzer($_SESSION['benutzername']);
            ?>
        </select></br>
        <input type="text" name="matrikelnummer" placeholder="Matrikelnummer" maxlength="7"></br>
        <input type="text" name="studentenname" placeholder="Name">
        <button type="submit" name="studentAnlegen">Student anlegen</button>
    </form>
</body>

</html>

<?php
$kursObj = new kursController();
if (isset($_POST['kursAnlegen'])) {
    $kursname = $_POST['Kurs'];
    //Prüfen, ob Feld "Kursname" ist leer
    if (empty($kursname)) {
        header("Location: ../DB2__NK_PHP/indexKurs.php?k=empty");
        exit();
    } else {
        //Prüfen, ob Kursnamen aus 3 Buchstaben am Anfang und drei Zahlen am Ende besteht. 
        if (!preg_match("/[a-zA-Z]{3}\d\d\d/", $kursname)) {
            header("Location: ../DB2__NK_PHP/indexKurs.php?k=char");
            exit();
        } else {
            //Prüfen, ob Kurs schon existiert
            if ($kursObj->checkKurs($kursname) != false) {
                header("Location: ../DB2__NK_PHP/indexKurs.php?k=nosuccess");
                exit();
            } else {
                $kursObj->createKurs($kursname);
                header("Location: ../DB2__NK_PHP/indexKurs.php?k=success");
                exit();
            }
        }
    }
}

if (isset($_POST['studentAnlegen'])) {
    $kursname = $_POST['kurses'];
    $matrikelnummer = $_POST['matrikelnummer'];
    $studentenname = $_POST['studentenname'];
    //Prüfen, ob alle Felder ausgefüllt worden sind
    if (empty($kursname) || empty($matrikelnummer) || empty($studentenname)) {
        header("Location: ../DB2__NK_PHP/indexKurs.php?s=empty");
        exit();
    } else {
        //Prüfen, ob Matrikelnummer aus 7 Ziffern besteht. 
        if (!preg_match("/\d\d\d\d\d\d\d/", $matrikelnummer)) {
            header("Location: ../DB2__NK_PHP/indexKurs.php?s=char");
            exit();
        } else {
            //Prüfen, ob Student schon existiert 
            if ($kursObj->checkStudent($matrikelnummer) != false) {
                header("Location: ../DB2__NK_PHP/indexKurs.php?s=nosuccess");
                exit();
            } else {
                $kursObj->createStudent($matrikelnummer, $studentenname, $kursname);
                header("Location: ../DB2__NK_PHP/indexKurs.php?s=success");
                exit();
            }
        }
    }
}

//Here we create an error message using GET methods, to see if we have a specific GET superglobal
//This method we can use with the PHP code in the above form, to prevent the data from being deleted in the inputs, if the user makes a mistake
//Zunächst wird geprüft, ob wir kein GET in der URL mit dem namen "k" haben.

//Kurs
if (!isset($_GET['k'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
    //Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
    $kurserstellen = $_GET['k'];
    //Then we check if the GET value is equal to a specific string
    if ($kurserstellen == "empty") {
        //If it is we create an error or success message!
        echo "<p class='error'>Bitte füllen Sie das Feld aus!</p>";
        exit();
    } elseif ($kurserstellen == "char") {
        echo "<p class='error'>Der Kursname muss aus drei Buchstaben folgend von 3 Ziffern bestehen!</p>";
        exit();
    } elseif ($kurserstellen == "nosuccess") {
        echo "<p class='error'>Diesen Kurs gibt es schon!</p>";
        exit();
    } elseif ($kurserstellen == "success") {
        echo "<p class='success'>Sie haben den Kurs erfolgreich erstellt.!</p>";
        exit();
    }
}

//Student
if (!isset($_GET['s'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else{
    //Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
    $studentstellen = $_GET['s'];
    //Then we check if the GET value is equal to a specific string
    if ($studentstellen == "empty") {
        //If it is we create an error or success message!
        echo "<p class='error'>Bitte füllen Sie alle Felder  aus!</p>";
        exit();
    } elseif ($studentstellen == "char") {
        echo "<p class='error'>Die Matrikelnummer muss aus sieben Ziffern bestehen!</p>";
        exit();
    } elseif ($studentstellen == "nosuccess") {
        echo "<p class='error'>Diesen Student gibt es schon!</p>";
        exit();
    } elseif ($studentstellen == "success") {
        echo "<p class='success'>Sie haben den Sudent erfolgreich erstellt.!</p>";
        exit();
    }
}
?>