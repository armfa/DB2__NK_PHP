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
  include_once 'classes/kurs.class.php';
  include_once 'classes/kursController.php';
  include_once 'classes/kursView.php';
?>

<html>
	<head>
		<title>Fragebogen freischalten</title>
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
    $freischaltenObj = new fragebogenController();
    if(isset($_POST['loeschen'])){
        $freischaltenObj->fragebogenFreischalten($kuerzel, $kursname);
    }

?>
