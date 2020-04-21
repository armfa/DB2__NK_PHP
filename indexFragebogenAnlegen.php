<?php
session_start();
$_SESSION["anzahlFragen"] = 0;
if (isset($_POST['fragebogenAnlegenStarten'])) {
$_SESSION["anzahlFragen"] = $_POST['anzahlFragen'];
}


?>

<html>
<?php
// kommentieren
?>
<form action="" method="post">
    <label for="TitelFragebogen">Titel Fragebogen:</label>
    <input type="text" name="titel"> <br><br>
    <label for="AnzahlFragen">Anzahl Fragen:</label>
    <input type="text" name="anzahlFragen">
    <input type="submit" name="fragebogenAnlegenStarten" value="Fragebogen erstellen" /><br>
</form>
<form  action="" method="post">
<?php

for($i = $_SESSION["anzahlFragen"]; $i > $_SESSION["anzahlFragen"]; $i++){
    echo '<input type="text" name="inhaltFrage">';
}
?>
</form>	      
<?php

//Wenn mindestens eine Frage erstellt werden kann, kann der Fragebogen erstellt und abgeschlossen werden.
if ($_SESSION['anzahlFragen']>= 1) {
    echo '<form action="" method="post">
<input type="submit" name="fragebogenAnlegen" value="Fragebogen anlegen" /><br>
</form>';
}
?>



</html>
