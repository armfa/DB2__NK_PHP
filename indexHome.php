<?php
include_once 'indexLogin.php';
include_once 'classes/home.php';
//Dana Geßler	
//22.04.2020


if (!isset($_SESSION['benutzername']) || empty($_SESSION['benutzername'])){
  header("Location: classes/home.php");
};



?>
<html>
<body>
Willkommen <?php echo $_SESSION['benutzername']; ?>
Login erfolgreich
</body>
</html>  
