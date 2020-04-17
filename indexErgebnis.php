+<?php
//Fabrice Armbruster 

/* 3. Ergebnisdarstellung
Ein Fragebogenerfasser kann einen von ihm freigeschalteten Fragebogen auswählen und über
eine Kursauswahl eine kursweise Auswertung durchführen. Er bekommt zu jeder Frage die
Durchschnitts-, Minimal-, Maximal und Standardabweichungswerte der Antworten als auch eine
Liste aller Kommentare dargestellt. Die Informationen sind über Aufrufe zentrale PHP-Funktionen
(siehe Punkt 4) zu ermitteln. */
?>

<html>

<body>
<h1>Ergbnisdarstellung</h1>

<label>Welchen Kurs möchten Sie auswerten?</label></br>
<label>Welchen Fragebogen möchten Sie auswerten?</label></br>

<h3>Was möchten Sie auswerten?</h3>

<form class='auswertung' action="" method="post">
    <label>Welchen Kurs möchten Sie auswerten?</label>
        <select name="auswertungKurs">
            <?php
            //Dropdownauswahl des Kurses
            //ToDo: aktueller Benutzer Übergeben     
            $ergbnisObject = new KursView();
            $ergbnisObject->showKursesfromBenutzer('Benutzer2');
            ?>
        </select></br>
    <label>Welchen Fragebogen möchten Sie auswerten?</label>
        <select name="fragebogen">
            <?php
            //Dropdownauswahl des fragebogens
            //ToDo: aktueller Benutzer Übergeben     
            $ergebnisVObject = new ErgebnisView();
            $ergebnisVObject->showFragebogenBenutzerKurs('Benutzer2');
            ?>
        </select></br>
    <button type="submit" name="fragebogenAuswerten">Fragebogen auswerten</button>
</form>

</body>

</html>

</body>

</html>