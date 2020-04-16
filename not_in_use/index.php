<?php
include_once 'signup.inc.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<h2>Signup</h2>
		<form action="includes/signup.inc.php" method="POST">
			<?php
				//ALL PHP inside this form is only needed if you want to prevent the data typed by the user from being deleted, when the user submits the form
				if (isset($_GET['first'])) {
					$first = $_GET['first'];
					echo '<input type="text" name="first" placeholder="Firstname" value="'.$first.'">';
				}
				else {
					echo '<input type="text" name="first" placeholder="Firstname">';
				}

				if (isset($_GET['last'])) {
					$last = $_GET['last'];
					echo '<input type="text" name="last" placeholder="Lastname" value="'.$last.'">';
				}
				else {
					echo '<input type="text" name="last" placeholder="Lastname">';
				}
			?>
			<input type="text" name="email" placeholder="E-mail">
			<?php
			if (isset($_GET['uid'])) {
				$uid = $_GET['uid'];
				echo '<input type="text" name="uid" placeholder="Username" value="'.$uid.'">';
			}
			else {
				echo '<input type="text" name="uid" placeholder="Username">';
			}
			?>
			<input type="password" name="pwd" placeholder="Password">
			<button type="submit" name="submit">Sign up</button>
		</form>

		<?php
			//Here we create the error message
			//The following are two examples of how we can do it

			//EXAMPLE 1
			//Here we create an error message by checking the URL, to see if we have a specific string inside of it
			//First we get the entire URL
			$fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			//Then we use strpos() to see if a specific string is inside the URL
			if (strpos($fullUrl, "signup=empty") == true) {
				//If it is, then we create an error message
				echo "<p class='error'>You did not fill in all fields!</p>";
				exit();
			}
			//Each elseif statement just continues checking for the error or success type we might have
			elseif (strpos($fullUrl, "signup=char") == true) {
				echo "<p class='error'>You used invalid characters!</p>";
				exit();
			}
			elseif (strpos($fullUrl, "signup=email") == true) {
				echo "<p class='error'>You used an invalid e-mail!</p>";
				exit();
			}
			elseif (strpos($fullUrl, "signup=success") == true) {
				echo "<p class='success'>You have been signed up!</p>";
				exit();
			}

			//EXAMPLE 2
			//Here we create an error message using GET methods, to see if we have a specific GET superglobal
			//This method we can use with the PHP code in the above form, to prevent the data from being deleted in the inputs, if the user makes a mistake
			//First we check if we DO NOT have a GET in the URL named "signup"
			if (!isset($_GET['signup'])) {
				//If not then we just exit the script and do nothing!
				exit();
			}
			else {
				//If we do have a GET, then we assign it to a variable
				$signupCheck = $_GET['signup'];
				//Then we check if the GET value is equal to a specific string
				if ($signupCheck == "empty") {
					//If it is we create an error or success message!
					echo "<p class='error'>You did not fill in all fields!</p>";
					exit();
				}
				elseif ($signupCheck == "char") {
					echo "<p class='error'>You used invalid characters!</p>";
					exit();
				}
				elseif ($signupCheck == "email") {
					echo "<p class='error'>You used an invalid e-mail!</p>";
					exit();
				}
				elseif ($signupCheck == "success") {
					echo "<p class='success'>You have been signed up!</p>";
					exit();
				}
			}
		?>
	</body>
</html>
