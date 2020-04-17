<?php
	session_start();
	if (isset($_SESSION['name']) == false)
	{ header ('Location: http://localhost/myindex.php');
	exit; 
	}
?>

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
		<table border="3" cellspacing="5" cellpadding="5">
            <tr>
                <th>Fragenummer</th>
                <th>Frage</th>
                <th>Löschen</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input type="submit" name="löschen" value="Löschen"/></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input type="submit" name="löschen" value="Löschen"/></td>
            </tr>
        </table>
		</form> <br> <br>

		<input type=""
        <input type="submit" name="kopieren" value="Fragebogen kopieren"/>

		</section>
		
		<hr>
		
		<footer>
			<p>
				&copy; 2020 Fabrice Armbruster, Dana Gessler, Isabelle Karin Scheffler DHBW Ravensburg
		</footer>
			
	</body>
</html>