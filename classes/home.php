<?php


if(isset($_SESSION['benutzername'])){
    echo "Welcome " .$_SESSION['benutzername'];
 //   header("Location: ../DB2__NK_PHP/indexLogin.php");
    }
    else
    {
        echo "Not Welcome";
//    header("Location: ../DB2__NK_PHP/indexLogin.php");


}
?>
