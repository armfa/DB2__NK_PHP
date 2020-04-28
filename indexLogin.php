<?php

//Dana Geßler + Fabrice Armbruster

//________________________BESCHREIBUNG______________________
//Diese Seite benhaltet alle Login-Funktionalitäten. 
//Studenten und Benutzer können sich einloggen
//Werden folgende Fälle unterschieden:
// - es wurde kein benutzername angegeben
// - es wurde eine passende 7-Stellige Matrikelnummer eingegeben
// - es wurde ein bekannter Benutzernamen mit richtigem/falschem Passwort eingegeben
// - es wird ein neuere Benutzernamen eingegeben
//      - in diesem Fall wird die Länge des Benutzernamens,
//      - die Zeichen (keine 7 Ziffern, da diese Für Matrikelnummern reserviert),
//      - sowie die Passwortlänge zwischen 8 und 64 Zeichen geprüft.
// - in allen Fehlerfällen wird eine Fehlermeldung ausgegeben. 

include_once 'classes/dbh.class.php';

//Automatischer Logout, wenn man auf diese Seite kommt. 
unset($_SESSION['benutzername']);
unset($_SESSION['matrikelnummer']);

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
                        <input type="password" name="Passwort" placeholder="nicht für Studenten">
                    </td>
                </tr>
                <tr>
                    <td></td>
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

    //Prüfen, ob Feld Benutzername leer ist
    if (empty($benutzername)) {
        header("Location: ../DB2__NK_PHP/indexLogin.php?login=empty");
        exit();
        //Prüfen, handelt es sich um einen Studenten, d.h. 7 Stellige Matrikelnummer  
    } elseif ($userObjekt->getStudentStmt($benutzername) == true and preg_match("/^\d{7}(?:\d{2})?$/", $benutzername) == true) {
        $_SESSION['matrikelnummer'] = $benutzername;
        header("Location: ../DB2__NK_PHP/index.php");
        exit();
        //Prüfen, ob es sich um einen schon bekannten Benutzer mit falschem Passwort handelt, d.h. Benutzername bekannt und Passwort falsch.
        //Passwort_Verify gibt true oder false zurück und ist standartfunktion von php -> Vorteil: wird automatisch aktualisiert. 
    } elseif ($userObjekt->getBenutzerStmt($benutzername) == true and password_verify($passwort, $userObjekt->getBenutzerStmt($benutzername)['Passwort']) == false) {
        header("Location: ../DB2__NK_PHP/indexLogin.php?login=passwordWrong");
        exit();
        //Prüfen, ob Benutzername nicht vorhanden ist und Passwort Feld nicht leer, sowie Benutzername nicht 7 Stellige Zahl (Matrikelnummer), d.h. neuer Benutzer angelegt wird. 
    } elseif (!$userObjekt->getBenutzerStmt($benutzername)) {
        //Prüfen, ob Benutzername nur eine 7 Stellige Matrikelnummer ist
        if (preg_match("/^\d{7}(?:\d{2})?$/", $benutzername)) {
            header("Location: ../DB2__NK_PHP/indexLogin.php?login=no7valueAllowed");
            exit();
        }
        if (strlen($benutzername) < 6 AND strlen($benutzername) > 40 ) {
            header("Location: ../DB2__NK_PHP/indexLogin.php?login=6username");
            exit();
        }
        //Prüfen, ob Passwort aus mindestens 8 und höchsetns 64 Zeichen besteht.
        if (strlen($passwort) < 8 or strlen($passwort) > 64) {
            header("Location: ../DB2__NK_PHP/indexLogin.php?login=pwdreqirementsnotmeet");
            exit();
        }
        //Nutzer wird neu angelegt und eingeloggt
        $userObjekt->setBenutzerStmt($benutzername, $hashedpwd);
        $_SESSION['benutzername'] = $benutzername;
        header("Location: ../DB2__NK_PHP/index.php");
        exit();
    } elseif ($userObjekt->getBenutzerStmt($benutzername) == true and password_verify($passwort, $userObjekt->getBenutzerStmt($benutzername)['Passwort']) == true) {
        //Erfolgreicher Login eines Benutzers     
        $_SESSION['benutzername'] = $benutzername;
        header("Location: ../DB2__NK_PHP/index.php");
        exit();
    }
}

if (!isset($_GET['login'])) {
    //Falls nicht, wird nichts gemacht und das Skript abgebrochen. 
    exit();
} else {
    //Falls ein GET existiert, wird nach der Zuordnung ausgewertet. 
    $loginstatus = $_GET['login'];
    if ($loginstatus == "empty") {
        echo "<p class='error'>Bitte geben Sie Ihren Benutzernamen oder Ihre Matrikelnummer an!</p>";
        exit();
    } elseif ($loginstatus == "passwordWrong") {
        echo "<p class='error'>Falsches Passwort!</p>";
        exit();
    } elseif ($loginstatus == "neuerBenutzerRegistriert") {
        echo "<p class='error'>Sie wurden als Benutzer registriert! Sie können sich nun mit Ihren Daten einloggen.</p>";
        exit();
    } elseif ($loginstatus == "no7valueAllowed") {
        echo "<p class='error'>Siebenstellige Ziffern sind nicht als Nutzernamen erlaubt.</p>";
        exit();
    } elseif ($loginstatus == "pwdreqirementsnotmeet") {
        echo "<p class='error'>Bitte wählen Sie ein Passwort aus, dass zwischen 8 und 64 Zeichen lang ist!</p>";
        exit();
    } elseif ($loginstatus == "6username") {
        echo "<p class='error'>Bitte wählen Sie ein Benutzernamen, der  aus mindestens 6  und höchstens 40 Zeichen besteht!</p>";
        exit();
    } elseif ($loginstatus == "nologin") {
        echo "<p class='error'>Bitte loggen Sie sich zuerst ein!</p>";
        exit();
    }
}

?>