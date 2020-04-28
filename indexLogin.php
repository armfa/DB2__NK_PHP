<?php
session_start();
?>
<?php

//Dana Geßler	
//16.04.2020

include_once 'classes/dbh.class.php';
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
        <bold> Eine Rücksetzung des Passworts ist nicht vorgesehen. </bold>
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
                        <input type="password" name="Passwort">
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
    $_SESSION[$benutzername]; 
    //Prüfen, ob Feld Benutzername leer ist
    if (empty($benutzername)) {
        header("Location: ../DB2__NK_PHP/indexLogin.php?login=empty");
        exit();
        //Student? 
    } elseif($userObjekt->getStudentStmt($benutzername)){
        session_start();
        $_SESSION['matrikelnummer']= $userObjekt['Matrikelnummer'];
        exit();
        //Benutzer?
    } elseif ($userObjekt->getBenutzerStmt($benutzername) == true and $userObjekt->getBenutzerStmt($passwort) == false) {
        header("Location: ../DB2__NK_PHP/indexLogin.php?login=loginfailed");
        //neue session
        exit();
        //Prüfen, ob Nutzer schon existiert
    } elseif ($userObjekt->getBenutzerStmt($benutzername) == false) {
        $userObjekt->setBenutzerStmt($benutzername, $passwort);
        $userObjekt->getLoginStmt($benutzername, $passwort);
        header("Location: ../DB2__NK_PHP/indexLogin.php?login=neuerBenutzerRegistriert");           //ToDo->auf index seite weiterleiten                                                                                                  //neue session -> login in session vermerken.               
        //neue session
        exit();
    } else {
        $userObjekt->getLoginStmt($benutzername, $passwort);
        $_SESSION['benutzername']= $userObjekt['Benutzername'];
        header("Location: ../DB2__NK_PHP/indexLogin.php?login=loginsuccess");
        session_start();
        exit();
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
        echo "<p class='error'>Bitte geben Sie einen Benutzernamen an!</p>";
        exit();
    } elseif ($loginstatus == "loginfailed") {
        echo "<p class='error'>Falsches Passwort!</p>";
        exit();
    } elseif ($loginstatus == "neuerBenutzerRegistriert") {
        echo "<p class='error'>Sie wurden als Benutzer registriert! Sie können sich nun mit Ihren Daten einloggen.</p>";
        exit();
    } elseif ($loginstatus == "loginsuccess") {
        echo "<p class='success'>Sie wurden erfolgreich eingeloggt!</p>";
        $name = $_SESSION['benutzername'];
        echo $name;
        header("Location: ../DB2__NK_PHP/indexHome.php");
        
        exit();
    }
}

?>
