<?php


//Dana Geßler	
//16.04.2020

 include_once 'OO_login/benutzer.class.php';
 include_once 'OO_login/benutzerController.php';
 include_once 'OO_login/benutzerView.php';
 include_once 'OO_login/home.php';
?>

<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>

  <body>
    <div id="container" class="container">
      <h1>Hier einloggen</h1>
      <strong>Wenn Sie noch nicht registriert sind, wird ein neuer Benutzer mit den eingegegeben Daten angelegt. </strong>
      <br> </br>
      <bold> Eine Rücksetzung des Passworts ist nicht vorgesehen.  </bold>
      <br> </br>
      <form action="" method="post" name="login">
        <table class="table " width="400">
          <tr>
            <th>Benutzername:</th>
            <td>
              <input type="text" name="Benutzername" required>
            </td>
          </tr>
          <tr>
            <th>Passwort:</th>
            <td>
              <input type="password" name="Passwort" required>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
              <input class="btn" type="submit" name="benutzerLogin" value="Login">
            </td>
          </tr>
          <tr>
        </table>
      </form>
    </div>
 </body>

 <?php
  $userObjekt = new benutzerController();
  if (isset($_POST['benutzerLogin'])) {
      $benutzername = $_POST['Benutzername'];
      $passwort = $_POST['Passwort'];
      //Prüfen, ob Feld Benutzername oder Feld Passwort leer sind
      if (empty($benutzername) || empty($passwort)) {
          header("Location: ../indexLogin.php?login=empty");
          exit();

        } elseif ($userObjekt->getBenutzerStmt($benutzername) == true AND $userObjekt->getBenutzerStmt($passwort) == false) {
          header("Location: ../indexLogin.php?login=loginfailed");
                  //neue session
                  exit();
          //Prüfen, ob Nutzer schon existiert
      } elseif ($userObjekt->getBenutzerStmt($benutzername) == false) {
                  $userObjekt->setBenutzerStmt($benutzername, $passwort);
                  $userObjekt->getLoginStmt($benutzername, $passwort);
                  header("Location: ../indexLogin.php?login=neuerBenutzerRegistriert");
                  //neue session
                  exit();

              } else {
                  $userObjekt->getLoginStmt($benutzername, $passwort);
                  header("Location: ../indexLogin.php?login=loginsuccess");
                  exit();
                  //neue session
              }
          }

  if (!isset($_GET['login'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
    exit();
} else {
    //Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
    $loginstatus = $_GET['login'];

    //Then we check if the GET value is equal to a specific string
    if ($loginstatus == "empty") {
        //If it is we create an error or success message!
        echo "<p class='error'>Bitte füllen Sie beide Felder aus!</p>";
        exit();
   } elseif ($loginstatus == "loginfailed") {
        echo "<p class='error'>Falsches Passwort!</p>";
        exit();
    } elseif ($loginstatus == "neuerBenutzerRegistriert") {
        echo "<p class='error'>Sie wurden als Benutzer registriert!</p>";
        exit();
    } elseif ($loginstatus == "loginsuccess") {
        echo "<p class='success'>Sie wurden erfolgreich eingeloggt!</p>";
        exit();
    }
}





?>