<?php
include_once 'classes/dbh.class.php';
include_once 'classes/befragung.class.php';
include_once 'classes/befragungController.php';
include_once 'classes/befragungView.php';


session_start();
?>
<?php
//Fabrice Armbruster
//19.04.2020-

$befragungsobjekt = new BefragungView();
$befragungC = new BefragungController();
$infoMessage = "";
$_SESSION["Fragen"] = $befragungsobjekt->showFrageStmt($_SESSION["kuerzel"]);

if (isset($_POST['fragebogen'])) {
    $_SESSION["kuerzel"] = $_POST['fragebogen'];
}
if ((isset($_POST['naechsteFrage']) == false) && (isset($_POST['vorherigeFrage']) == false)) {
    $_SESSION["aktuelleSeite"] = 1;
    $_SESSION["anzahlSeiten"] = 2 + $befragungsobjekt->showAnzahlFragenFragebogenStmt($_SESSION["kuerzel"])[0];
}
if (isset($_POST['naechsteFrage'])) {
    //Check, ob es vorletzte Frage ist 
    if ($_SESSION["aktuelleSeite"] == ($_SESSION["anzahlSeiten"] - 1)) {
        $kommentar = $_POST['kommentar'];
        $befragungC->createOrUpdateKommentarStmt($_SESSION["kuerzel"], 2345667, $kommentar);
        $_SESSION["aktuelleSeite"]++;
    }
    //Check, ob Antwort abgegeben wurde
    if (isset($_POST['Antwort'])) {
        $antwort = $_POST['Antwort'];
        //Antwort in DB schreiben
        $Fragenummer = $_SESSION["Fragen"][$_SESSION["aktuelleSeite"] - 1]["Fragenummer"];
        $befragungC->createOrUpdateFrageAntwortStmt($Fragenummer, $_SESSION["kuerzel"], 2345667, $antwort);      //toDo Benutzer   
        $_SESSION["aktuelleSeite"]++;
        //keine Antwort wurde abgegeben -> Nachricht an Benutzer 
    }/*  elseif(isset($_POST['Antwort']) == false && $_SESSION["aktuelleSeite"] < ($_SESSION["anzahlSeiten"] - 1)) {
        $infoMessage =  "<p class='error'>Bitte wählen Sie eine Antwort aus um zur nächsten Frage zu kommen!</p>";
    } */
}
if (isset($_POST['vorherigeFrage'])) {
    $_SESSION["aktuelleSeite"]--;
}

//Kommentar in db speichern und Fragebogen als abgeschlossen markieren
if (isset($_POST['fragebogenFertig'])) {
    $befragungC->createKommentarFragebogenFertig($_SESSION["kuerzel"], 2345667, 1, $_POST['kommentar']);
}

//Abgegebene Antworten aus DB laden 
if ($_SESSION["aktuelleSeite"] < ($_SESSION["anzahlSeiten"] - 1)){
echo "</br>";
$check = $befragungsobjekt->showFrageAntwortStmt($_SESSION["kuerzel"], 2345667)[$_SESSION["aktuelleSeite"]-1]['Antwort'];
switch($check){
 case 1: $check1 = "checked"; $check2 = $check3 =  $check4 = $check5 = ""; break;
 case 2: $check2 = "checked"; $check1 = $check3 =  $check4 = $check5 = ""; break;
 case 3: $check3 = "checked"; $check1 = $check2 =  $check4 = $check5 = ""; break;
 case 4: $check4 = "checked"; $check1 = $check2 =  $check3 = $check5 = ""; break;
 case 5: $check5 = "checked"; $check1 = $check2 =  $check3 = $check4 = ""; break;
 default: $check1 = $check2 =  $check3 = $check4 = $check5 = "";
}
echo "</br>";
//$_SESSION["Antworten"] = $befragungsobjekt->showFrageAntwortStmt($_SESSION["kuerzel"], 2345667); //toDo Benutzer   //Antworten  aus db 
//$_SESSION["Fragen"] = $befragungsobjekt->showFrageStmt($_SESSION["kuerzel"]);
}
?>

<html>

<body>
    <h1>Fragebogen: <?php echo $befragungsobjekt->showFragebogenTitelStmt($_SESSION["kuerzel"])['Titel']; ?></h1>
    <form action="" method="post">
        <?php
        //ToDo: Erzeugen des Seiteninhalts über Datenbankzugriffe;
        if ($_SESSION["aktuelleSeite"] < ($_SESSION["anzahlSeiten"] - 1)) {
            print_r($_SESSION["Fragen"][$_SESSION["aktuelleSeite"] - 1]["InhaltFrage"]);
        } elseif ($_SESSION["aktuelleSeite"] == ($_SESSION["anzahlSeiten"] - 1)) {
            echo "<p>Wir freuen uns auf Ihren Kommentar!</p></br><textarea name='kommentar' rows='5' cols='70' placeholder='Hier können Sie noch Lob und weitere Kritik äußern. Vielen Dank!'></textarea>";
        } else
        ?>
        <?php if ($_SESSION["aktuelleSeite"] <  ($_SESSION["anzahlSeiten"] - 1)){
        echo '<fieldset>
            <input type="radio" id="1" name="Antwort" value="1" '.$check1.'>
            <label for="1"> sehr gut</label> 
            <input type="radio" id="2" name="Antwort" value="2" '.$check2.'>
            <label for="2"> eher gut</label>
            <input type="radio" id="3" name="Antwort" value="3" '.$check3.'>
            <label for="3"> ausgeglichen</label> 
            <input type="radio" id="4" name="Antwort" value="4" '.$check4.'>
            <label for="4"> eher schlecht</label> 
            <input type="radio" id="5" name="Antwort" value="5" '.$check5.'>
            <label for="5"> sehr schlecht</label> 
        </fieldset>';
    }

    //ToDo: Erzeugen des Seiteninhalts über Datenbankzugriffe;
    echo "<div>Inhalt der Seite " . $_SESSION["aktuelleSeite"] . " von " . $_SESSION["anzahlSeiten"] . "</div></br>";
        ?>


        <input type="submit" name="vorherigeFrage" value="Vorherige Frage" <?php
                                                                            if ($_SESSION["aktuelleSeite"] ==  1) {
                                                                                echo " disabled ";
                                                                            }
                                                                            ?>>
        <input type="submit" name="naechsteFrage" value="Nächste Frage" <?php
                                                                        if ($_SESSION["aktuelleSeite"] ==  $_SESSION["anzahlSeiten"]) {
                                                                            echo " disabled ";
                                                                        }
                                                                        ?>>
        <?php

        if ($_SESSION["aktuelleSeite"] ==  $_SESSION["anzahlSeiten"]) {
            echo '<button type="submit" name="fragebogenFertig">Fragebogen abschließen</button>';
        }
        ?>
    </form>

    <?php
    if ($infoMessage != "") {
        echo $infoMessage;
    }

    ?>

</body>


</html>