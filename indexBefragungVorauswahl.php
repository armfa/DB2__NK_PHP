<?php
//Fabrice Armbruster

//________________________BESCHREIBUNG______________________
//Diese Seite dient als Vorauswahl, auf der der Student die für ihn 
//freigeschalteten und noch nicht abgegebenen Umfragen aufrufen kann. 

include_once 'classes/dbh.class.php';

//Diese Seite akzeptiert nur Studenten
if (isset($_SESSION['matrikelnummer']) == false) {
    //Falls Student nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
    //Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}

$befragungControll = new BefragungController();
?>

<!doctype HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Befragung</title>
</head>

<body>
    <!--Link um zurück auf die Startseite zu kommen bzw. Logout-->
    <header style="background-color:lightGray;">
        <ul>
            <li><a href="index.php">Zurück zur Startseite</a></li>
            <li><a href="indexLogin.php">Logout</a></li>
        </ul>
    </header>
    
    <h1>Welche Umfrage möchten Sie starten?</h1>

    <?php
    if (isset($_GET['k'])) {
        echo "<p class='success'>Sie haben den Fragebogen erfolgreich abgeschickt!</p>";
    }

    //Darf ein Student ein Fragebogen aufrufen -> Array mit Liste der Fragebögen, 
    //die für diesen Studenten freigegeben sind, und die dieser noch nicht abgegeben hat
    $resultx = $befragungControll->darfStudentFragebogenausfuellen($_SESSION['matrikelnummer']);
    ?>

    <?php
    if ($resultx != null) {
        //Dropdownauswahl des Fragebogens, welcher für diesen Student freigeschalten ist.     
        echo '<form action="indexBefragung.php" method="post">';
        echo '<select name="fragebogen">';
        $i = 0;
        while ($i < count($resultx)) {
            echo "<option value='" . $resultx[$i]['Kuerzel'] . "'>" . $resultx[$i]['Titel'] . "</option>";
            $i++;
        }
        echo '</select></br></br>
        <button type="submit" name="umfrageStarten">Umfrage starten</button></form>';
    } else {
        echo "Super, du hast schon alle Umfragen beantwortet!";
    }
    ?>
</body>

</html>