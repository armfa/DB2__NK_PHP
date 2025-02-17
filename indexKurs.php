<?php
//Fabrice Armbruster

//Auf dieser Seite Kann der Benutzer einen Kurs erstellen und einen Student erstellen und dabei diesem einem Kurs zuweisen.
//Hierzu werden die Datenbankfunktionen in "kurs.class.php" genutzt. 

include_once 'classes/dbh.class.php';

//Diese Seite akzeptiert nur Benutzer
if (isset($_SESSION['benutzername']) == false) {
    //Falls Benutzer nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
    //Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kurs</title>
</head>

<body>
    <!--Link um zurück auf die Startseite zu kommen bzw. Logout-->
    <header style="background-color:lightGray;">
        <ul>
            <li><a href="index.php">Zurück zur Startseite</a></li>
            <li><a href="indexLogin.php">Logout</a></li>
        </ul>
    </header>


    <!--Kurs anlegen-->
    <h3>Neuen Kurs anlegen</h3>
    <form class='neuerKurs-form' action="" method="post">
        <input type="text" name="Kurs" placeholder="Kurs">
        <button type="submit" name="kursAnlegen">Kurs anlegen</button>
    </form>
    <!--Student anlegen und Kurs zuweisen-->
    <h3>Neuen Student anlegen</h3>
    <form class='neuerStudent-form' action="" method="post">
        <label>Kurs</label>
        <select name="kurses">
            <?php
            //Dropdownauswahl: alle Kurse werden dem Benutzer zur Auswahl angezeigt
            $kurs = new Kurs();
            $kursname = $kurs->getKurses($_SESSION['benutzername']);
            $i = 0;
            while ($i < count($kursname)) {
                echo "<option value='" . $kursname[$i]['Kursname'] . "'>" . $kursname[$i]['Kursname'] . "</option>";
                $i++;
            }
            ?>
        </select></br>
        <input type="text" name="matrikelnummer" placeholder="Matrikelnummer" maxlength="7"></br>
        <input type="text" name="studentenname" placeholder="Name">
        <button type="submit" name="studentAnlegen">Student anlegen</button>
    </form>
</body>

</html>

<?php
//Kurs anlegen
if (isset($_POST['kursAnlegen'])) {
    $kursname = htmlspecialchars($_POST['Kurs']);
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
            if ($kurs->checkIfKursExists($kursname) != false) {
                header("Location: ../DB2__NK_PHP/indexKurs.php?k=nosuccess");
                exit();
            } else {
                $kurs->setKursStmt($kursname);
                header("Location: ../DB2__NK_PHP/indexKurs.php?k=success");
                exit();
            }
        }
    }
}

//Student anlegen
if (isset($_POST['studentAnlegen'])) {
    $kursname = $_POST['kurses'];
    $matrikelnummer = htmlspecialchars($_POST['matrikelnummer']);
    $studentenname = htmlspecialchars($_POST['studentenname']);
    //Prüfen, ob alle Felder ausgefüllt worden sind
    if (empty($kursname) || empty($matrikelnummer) || empty($studentenname)) {
        header("Location: ../DB2__NK_PHP/indexKurs.php?s=empty");
        exit();
    } else {
        //Prüfen, ob Matrikelnummer aus 7 Ziffern besteht. 
        if (!preg_match("/^\d{7}(?:\d{2})?$/", $matrikelnummer)) {
            header("Location: ../DB2__NK_PHP/indexKurs.php?s=char");
            exit();
        } else {
            //Prüfen, ob Student schon existiert 
            if ($kurs->checkIfStudentExists($matrikelnummer) != false) {
                header("Location: ../DB2__NK_PHP/indexKurs.php?s=nosuccess");
                exit();
            } else {
                $kurs->setStudentStmt($matrikelnummer, $studentenname, $kursname);
                header("Location: ../DB2__NK_PHP/indexKurs.php?s=success");
                exit();
            }
        }
    }
}

//Fehlermeldungen im GET 
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
        echo "<p class='success'>Sie haben den Kurs erfolgreich erstellt!</p>";
        exit();
    }
}

//Student
if (!isset($_GET['s'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
} else {
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
        echo "<p class='success'>Sie haben den Student erfolgreich erstellt.</p>";
        exit();
    }
}
?>