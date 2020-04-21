<?php
session_start();
$_SESSION["AnzahlFragenSession"] = 0;
if (isset($_POST['fragebogenAnlegenStarten'])) {
$_SESSION["AnzahlFragenSession"] = $_POST['anzahlFragen'];
}


?>

<html>
<?php
// Eingabe des Titels und der Anzahl der Felder 
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

// Input-Felder erstellen nach Anzahl der gewünschten Fragen. 
$i = 1;
while($i <= $_SESSION["AnzahlFragenSession"]){
    echo '<label for="inhaltFrage"> Frage '.$i.'</label>';
    echo '<input type="text" name="inhaltFrage'.$i.'"></br>';
    $i++;
}
?>
</form>	      
<?php

//Wenn mindestens eine Frage erstellt werden kann, kann der Fragebogen erstellt und abgeschlossen werden.
if ($_SESSION['AnzahlFragenSession']>= 1) {
    echo '<form action="" method="post">
<input type="submit" name="fragebogenAnlegen" value="Fragebogen anlegen" /><br>
</form>';
}
?>



</html>
