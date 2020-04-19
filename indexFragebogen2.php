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
		<title>Fragebogen bearbeiten</title>
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

            <form class='bearbeitenFragebogen-form' action="" method="post">    
                <select name="fragebogen">
                <?php     
                    $frageObject = new FragebogenView();
                    $frageObject->showFragebogenVonBenutzer($_SESSION['Benutzername']);
                ?>
                </select></br><br><br>
		        <table border="3" cellspacing="5" cellpadding="5">
                <tr>
                    <th>Frage</th>
                    <th>Löschen</th>
                </tr>
                <?php
                    $frageObject->showFragenVonFragebogen('fragebogen');
                ?>
                </table><br><br>
		        
                <input type="submit" name="kopieren" value="Fragebogen kopieren"/>
                <input type="submit" name="loeschen" value="Fragebogen loeschen"/><br>

                <br><br>

                <a href="indexFragebogen3.php">Fragebogen freischalten</a>

			</form>
            <br>
			
		</section>
		
		<hr>
		
		<footer>
			<p>
				&copy; 2020 Fabrice Armbruster, Dana Gessler, Isabelle Karin Scheffler DHBW Ravensburg
		</footer>
			
	</body>
</html>

