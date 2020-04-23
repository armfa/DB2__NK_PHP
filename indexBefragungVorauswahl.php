<?php

include_once 'classes/dbh.class.php';
include_once 'classes/befragung.class.php';
include_once 'classes/befragungController.php';
include_once 'classes/befragungView.php';

?>

<!doctype HTML>
<html>

<body>
    <h1>Welche Umfrage möchten Sie starten?</h1>

<?php
    if (!isset($_GET['k'])) {
        echo "<p class='success'>Sie haben den Fragebogen erfolgreich abgeschickt!</p>";
    }
?>

<form action="indexBefragung.php" method="post">
        <label>Fragebogen</label>
        <select name="fragebogen">
            <?php
            //Dropdownauswahl des Fragebogens, welcher für diesen Student freigeschalten ist. 
            //ToDo: aktueller Benutzer Übergeben     
            $bContr = new BefragungView();
            $bContr->showFragebogenfromBenutzer('user1'); //ToDo: benutzer einbinden
            ?>
        </select></br>
        <button type="submit" name="umfrageStarten">Umfrage starten</button>
    </form>
</body>




</html>