<?php
    //session_start();


  include_once 'classes/dbh.class.php';
  include_once 'classes/fragebogen.class.php';
  include_once 'classes/fragebogenController.php';
  include_once 'classes/fragebogenView.php';
  include_once 'indexFragebogenAnlegen.php';

?>

<html>
	<head>
		<title>Fragebogen erstellen</title>
        <?php
            $_SESSION['Benutzername'] = "user1";
        ?>
	</head>
	
	<body>
		
        <a href="indexStartseite.php">Startseite</a>
        <a href="/indexFragebogenAnlegen.php">Fragebogen anlegen</a></br>
        <a href="indexFragebogen2.php">Fragebogen bearbeiten</a></br>
        <a href="indexFragebogen3.php">Fragebogen freischalten</a></br>
			
	</body>
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
