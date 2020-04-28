<?php

//Dana Geßler	

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
    </br>
        <bold> Eine Rücksetzung des Passworts ist nicht vorgesehen. </bold>
        </br></br>
        <form action="" method="post" name="login">
            <table class="table " width="400">
                <tr>
                    <th>Benutzername/ Matrikelnummer:</th>
                    <td>
                        <input type="text" name="Benutzername">
                    </td>
                </tr>
                <tr>
                    <th>Passwort:</th>
                    <td>
                        <input type="password" name="Passwort" placeholder="nicht für Studenten" >
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
    $hashedpwd = password_hash($passwort, PASSWORD_DEFAULT); 

    $_SESSION['matrikelnummer'] = "";
    $_SESSION['benutzername'] = "";

    //Prüfen, ob Feld Benutzername leer ist
    if (empty($benutzername)) {
        header("Location: ../DB2__NK_PHP/indexLogin.php?login=empty");
        exit();
    //Prüfen, handelt es sich um einen Studenten, d.h. 7 Stellige Matrikelnummer  
    } elseif($userObjekt->getStudentStmt($benutzername) == true AND preg_match("/\d\d\d\d\d\d\d/", $benutzername) == true){
        $_SESSION['matrikelnummer'] = $benutzername;
        echo "student";
        //header("Location: ../DB2__NK_PHP/index.php");
        exit();
    //Prüfen, ob es sich um einen schon bekannten Benutzer mit falschem Passwort handelt, d.h. Benutzername bekannt und Passwort falsch.
    //Passwort_Verify gibt true oder false zurück und ist standartfunktion von php -> Vorteil: wird automatisch aktualisiert. 
    } elseif ($userObjekt->getBenutzerStmt($benutzername) == true AND password_verify($passwort, $userObjekt->getBenutzerStmt($benutzername)['Passwort']) == false) {
        //header("Location: ../DB2__NK_PHP/indexLogin.php?login=passwordWrong");
        echo "password !=";
        exit();
    //Prüfen, ob Benutzername nicht vorhanden ist und Passwort Feld nicht leer, sowie Benutzername nicht 7 Stellige Zahl (Matrikelnummer), d.h. neuer Benutzer angelegt wird. 
    } elseif (!$userObjekt->getBenutzerStmt($benutzername)){ 
        //Prüfen, ob Benutzername nur eine 7 Stellige Matrikelnummer ist
/*         if(!preg_match("/\d\d\d\d\d\d\d/", $benutzername)) {
            //header("Location: ../DB2__NK_PHP/indexLogin.php?login=loginfailed");
            echo "no 7 value allowed";
            exit();
        } */
        //Prüfen, ob Passwort aus mindestens 8 und höchsetns 64 Zeichen besteht.
        if(mb_strlen($passwort) < 8 OR mb_strlen($passwort) > 64 ){
            echo "pwd requirements not meet";
            //header("Location: ../DB2__NK_PHP/indexLogin.php?login=loginfailed");
            exit();
        }
        //Nutzer wird neu angelegt
        $userObjekt->setBenutzerStmt($benutzername, $hashedpwd);
        echo "neuer user angelegt";
     /*    $userObjekt->getLoginStmt($benutzername, $passwort);
        header("Location: ../DB2__NK_PHP/index.php"); 
        $_SESSION['benutzername'] = $benutzername;   */         
        exit();
    } elseif($userObjekt->getBenutzerStmt($benutzername) == true AND password_verify($passwort, $userObjekt->getBenutzerStmt($benutzername)['Passwort']) == true){
        //Erfolgreicher Login eines Benutzers     
        $_SESSION['benutzername'] = $benutzername;
        echo "login benutzer";
        //header("Location: ../DB2__NK_PHP/index.php");
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
        echo "<p class='error'>Bitte geben Sie Ihren Benutzernamen oder Ihre Matrikelnummer an!</p>";
        exit();
    } elseif ($loginstatus == "passwordWrong") {
        echo "<p class='error'>Falsches Passwort!</p>";
        exit();
    } elseif ($loginstatus == "neuerBenutzerRegistriert") {
        echo "<p class='error'>Sie wurden als Benutzer registriert! Sie können sich nun mit Ihren Daten einloggen.</p>";
    }
}

?>
