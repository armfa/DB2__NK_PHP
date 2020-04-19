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

if ((isset($_POST['naechsteFrage']) == false) && (isset($_POST['vorherigeFrage']) == false)) {
    $_SESSION["aktuelleSeite"] = 1;
    $_SESSION["anzahlSeiten"] = 1 + $befragungsobjekt->showAnzahlFragenFragebogenStmt("1")[0];
}
if (isset($_POST['naechsteFrage'])) {
    $_SESSION["aktuelleSeite"]++;
}
if (isset($_POST['vorherigeFrage'])) {
    $_SESSION["aktuelleSeite"]--;
}
if (isset($_POST['fragebogen'])) {
    $_SESSION["kuerzel"] = $_POST['fragebogen'];
}

$_SESSION["Fragen"] = $befragungsobjekt->showFrageStmt("1");        //ToDo-> Fragebogenkürzel aus auswahl übergeben. 
?>

<html>

<body>
    <h1>Fragebogen: <?php echo $befragungsobjekt->showFragebogenTitelStmt( $_SESSION["kuerzel"])['Titel']; ?></h1>
    <?php
    //ToDo: Erzeugen des Seiteninhalts über Datenbankzugriffe;
    if ($_SESSION["aktuelleSeite"] < $_SESSION["anzahlSeiten"]) {
        print_r($_SESSION["Fragen"][$_SESSION["aktuelleSeite"] - 1]["InhaltFrage"]);
    } else
        echo "<p>Wir freuen uns auf Ihren Kommentar!</p></br>
    <textarea id='kommentar' rows='5' cols='70' placeholder='Hier können Sie noch Lob und weitere Kritik äußern. Vielen Dank!'>
    </textarea>"
    ?>
    <form action="" method="post">
        <?php if ($_SESSION["aktuelleSeite"] !=  $_SESSION["anzahlSeiten"])
            echo '<fieldset>
    <input type="radio" id="1" name="Antwort" value="1">
    <label for="1"> sehr gut</label> 
    <input type="radio" id="2" name="Antwort" value="2">
    <label for="2"> eher gut</label>
    <input type="radio" id="3" name="Antwort" value="3">
    <label for="3"> ausgeglichen</label> 
    <input type="radio" id="4" name="Antwort" value="4">
    <label for="4"> eher schlecht</label> 
    <input type="radio" id="5" name="Antwort" value="5">
    <label for="5"> sehr schlecht</label> 
  </fieldset>';

        //ToDo: Erzeugen des Seiteninhalts über Datenbankzugriffe;
        echo "Inhalt der Seite " . $_SESSION["aktuelleSeite"] . " von " . $_SESSION["anzahlSeiten"];
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

</body>


</html>