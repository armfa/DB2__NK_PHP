<?php
    session_start();
  /*session_start();
  if (isset($_SESSION['name']) == false)
  { header ('Location: http://localhost/myindex.php');
  exit; 
  }*/

  include_once 'classes/dbh.class.php';
  include_once 'classes/fragebogen.class.php';
  include_once 'classes/fragebogenController.php';
  include_once 'classes/fragebogenView.php';
?>

<html>
	<head>
		<title>Frage anlegen</title>
        <?php
            $_SESSION['Benutzername'] = "user1";
        ?>
	</head>
	
	<body>
        <header>
			<div id="logo">
				<a href="#">
					<img src="Logo_DHBW.png" alt="Logo" style="width:150px;height:100px;">
				</a>
			</div>
            <nav id="main-nav">
				<ul>
					<li><a href="indexStartseite.php">Startseite</a></li>
				<ul>
			</nav>
		</header>
		
		<hr>
               
        

		
		
		<section style="background-color:lightgrey;">
            <br><br>

            <form class='neueFrage-form' action="" method="post">
                <label for="Frage">Frage:</label>
				<input type="text" name="inhaltFrage">
                <input type="submit" name="frageAnlegen" value="Frage hinzufuegen"/><br><br>
            </form>	
                
            <br><br>
			
		</section>
		
		<hr>
		
		<footer>
			<p>
				&copy; 2020 Fabrice Armbruster, Dana Gessler, Isabelle Karin Scheffler DHBW Ravensburg
		</footer>
			
	</body>
</html>

<?php

    $frageObj = new fragebogenController();
    if(isset($_POST['frageAnlegen'])){
        $frage = $_POST['inhaltFrage'];
        // Wie komm ich hier auf das Kuerzel?????????
        $kuerzel = $this->getKuerzelVonFrage('inhaltFrage');
        //Prüfen, ob Feld "Frage" leer ist
        if (empty($frage)) {
            header("Location: ../DB2__NK_PHP/indexFrage1.php?k=empty");
            exit();
        } else {
            //Prüfen, ob Frage schon existiert
            if ($frageObj->checkFrage($frage) != false) {
                header("Location: ../DB2__NK_PHP/indexFrage1.php?k=nosuccess");
                exit();
            } else {
                $frageObj->createFrage($frage, $kuerzel);
                header("Location: ../DB2__NK_PHP/indexFrage1.php?k=success");
                exit();
            }
        }
    }
        
    if (!isset($_GET['k'])) {
        //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
    } else {
        //Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
        $frageErstellen = $_GET['k'];
        //Then we check if the GET value is equal to a specific string
        if ($frageErstellen == "empty") {
            //If it is we create an error or success message!
            echo "<p class='error'>Bitte füllen Sie das Feld aus!</p>";
            exit();
        } elseif ($frageErstellen == "nosuccess") {
            echo "<p class='error'>Diese Frage gibt es schon!</p>";
            exit();
        } elseif ($frageErstellen == "success") {
            echo "<p class='success'>Sie haben die Frage erfolgreich erstellt.!</p>";
            exit();
        }
    }
?>

