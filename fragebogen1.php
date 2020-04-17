<html>
	<head>
		<title>Umfragetool</title>
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
					<li><a href="#Startseite">Startseite</a></li>
					<li><a href="#Ausloggen">Ausloggen</a></li>
				<ul>
			</nav>
		</header>
		
		<hr>
		
		<section id="Startseite" style="background-color:lightgrey;">
			<form method="post">
			<label for="TitelFragebogen">Titel Fragebogen:</label>
				<input type="text" name="Titel" id="TitelFragebogen" pattern="[A-Z,0-9]" required> <br>
				<label for="AnzahlFragen">Anzahl Fragen:</label>
				<input type="text" name="AnzahlFragen" id="AnzahlFragen" pattern="[0-9]" required>
			</form>

			<?php
				$sql = "SELECT Titel FROM Fragebogen WHERE Titel='TitelFragebogen'";
				$result = mysql_query($sql);
				$count = mysql_num_rows($result);
					if ($count == 1)
						{echo "Dieser Titel ist bereits vergeben";}
					else { "Insert into Titel (Titel, Benutzername) Values('TitelFragebogen', User;"}
			?>

			<input type="submit" name="hinzufügen" value="Fragebogen hinzufuegen"/><br>
		
			<form>
			<label for="Frage">Frage:</label>
				<input type="text" id="Frage" pattern="[A-Z,0-9]" required> <br>
			</form>

			<input type="submit" name="hinzufügen" value="Frage hinzufuegen"/><br>

			<a href="fragebogen2.php"><input type="submit" name="erstellen" value="Fragebogen erstellen"/></a>
		
		</section>
		
		<hr>
		
		<footer>
			<p>
				&copy; 2020 Fabrice Armbruster, Dana Gessler, Isabelle Karin Scheffler DHBW Ravensburg
		</footer>
			
	</body>
</html>