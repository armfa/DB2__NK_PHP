<?php
//Fabrice Armbruster

//______________________KLASSENBESCHREIBUNG______________________
//Diese Seite dient als Naviagationsseite, von der der Benutzer die für ihn erlaubten Seiten angezeigt bekommt. 

include_once 'classes/dbh.class.php';

//Prüfen, ob Login schon erfolgt ist, bzw ob und welche Funktionen der Benutzer/ Student hier angezeigt bekommt. 
  if (isset($_SESSION['benutzername']) == false AND isset($_SESSION['matrikelnummer']) == false) {
    //Falls nicht eingeloogt, wird der Benutzer/Student auf die Loginseite weitergeleitet.
    header("Location: ../DB2__NK_PHP/indexLogin.php?login=nologin");
    //exit();
} 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hochschule Umfragen</title>
</head>

<body> 
    <div class=topHeader>
        <h1>Herzlich Willkommen im Befragungstool, was möchten Sie tun?</h1>
    </div>
    <div>


    <?php
    //Falls der Benutzer eingeloggt ist 
    if (isset($_SESSION['benutzername'])) {
        echo         
    '<div>
        <a href="indexKurs.php">Kurs anlegen, Studenten anlegen und Kurs zuweisen</a>
    </div>
    <div>
        <a href="indexFragebogen.php">Fragebogen anlegen, bearbiten kopieren, freigeben</a>
    </div>
    <div>
        <a href="indexErgebnis.php">Ergebnisse aufrufen</a>
    </div>';
    }

    //Falls der Student eingeloggt ist 
    if (isset($_SESSION['matrikelnummer'])) {
        echo 
        '<div>
        <a href="indexBefragungVorauswahl.php">Fragebogen ausfüllen</a>
        </div>';
    }
    ?>

</body>

</html>