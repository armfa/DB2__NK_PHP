<?php
    //session_start();


  include_once 'classes/dbh.class.php';
  include_once 'classes/fragebogen.class.php';
  include_once 'classes/fragebogenController.php';
  include_once 'classes/fragebogenView.php';


session_start();
$_SESSION["AnzahlFragenSession"] = 0;
if (isset($_POST['fragebogenAnlegenStarten'])) {
$_SESSION["AnzahlFragenSession"] = $_POST['anzahlFragen'];
}

?>
<html>
<h4>Fragebogen anlegen</h4>
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

<h4>Fragebogen freigeben</h4>
<section>
            <br><br>

            <form class='bearbeitenFragebogen-form' action="" method="post" disabled>    
                <select name="fragebogen">
                <?php     
                    $frageObject = new FragebogenView();
                    $frageObject->showFragebogenVonBenutzer($_SESSION['Benutzername']);
                ?>
                </select></br><br><br>
		        
                <select name="kurses">
                <?php
                    $benutzerObject = new KursView();
                    $benutzerObject->showKursesfromBenutzer($_SESSION['Benutzername']);
                ?>
                </select></br><br><br>

                <input type="submit" name="freigeben" value="Fragebogen freigeben"/>

			</form>
</html>





<?php
    /* $fragebogenObj = new fragebogenController();
    if(isset($_POST['fragebogenAnlegen'])){
        $fragebogen = $_POST['titel'];
        $anzahlFragen = $_POST['AnzahlFragen'];
        $benutzername = $_SESSION['Benutzername'];
        //Prüfen, ob Feld "Fragebogen" leer ist
        if ((empty($fragebogen)) or (empty($anzahlFragen))) {
            header("Location: ../DB2__NK_PHP/indexFragebogen1.php?k=empty");
            exit();
        } else {
            // Prüfen, ob AnzahlFragen richtig ausgefüllt wurde
            if ((!preg_match("/[0-9]/", $anzahlFragen)) and ($anzahlFragen <= 20)) {
                header("Location: ../DB2__NK_PHP/indexFragebogen1.php?k=char");
                exit();
            }
            //Prüfen, ob Fragebogen schon existiert
            if ($fragebogenObj->checkFragebogen($fragebogen) != false) {
                header("Location: ../DB2__NK_PHP/indexFragebogen1.php?k=nosuccess");
                exit();
            } else {
                $fragebogenObj->createFragebogen($fragebogen, $benutzername);
                header("Location: ../DB2__NK_PHP/indexFragebogen1.php?k=success");
                exit();
            }
        }
    }
        
    if (!isset($_GET['k'])) {
        //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
    } else {
        //Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
        $fragebogenErstellen = $_GET['k'];
        //Then we check if the GET value is equal to a specific string
        if ($fragebogenErstellen == "empty") {
            //If it is we create an error or success message!
            echo "<p class='error'>Bitte füllen Sie das Feld aus!</p>";
            exit();
        } elseif ($fragebogenErstellen == "char") {
            echo "<p class='error'>Bitte füllen Sie das Feld mit Zahlenwerten aus!</p>";
            exit();
        } elseif ($fragebogenErstellen == "nosuccess") {
            echo "<p class='error'>Diesen Fragebogen gibt es schon!</p>";
            exit();
        } elseif ($fragebogenErstellen == "success") {
            header("Location: ../DB2__NK_PHP/indexFrage1.php");
            // echo "<p class='success'>Sie haben den Fragebogen erfolgreich erstellt.!</p>";
            exit();
        }
    } */
    
?>
