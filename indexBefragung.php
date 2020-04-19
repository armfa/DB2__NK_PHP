<?php 
session_start();
?>
<?php
//Fabrice Armbruster
//19.04.2020-

if ((isset($_POST['naechsteFrage']) == false) && (isset($_POST['vorherigeFrage']) == false)){
    $_SESSION["aktuelleSeite"] = 1;
    $_SESSION["anzahlSeiten"] = 5;
}
if (isset($_POST['naechsteFrage'])){
    $_SESSION["aktuelleSeite"] ++;
}
if (isset($_POST['vorherigeFrage'])){
    $_SESSION["aktuelleSeite"] --;
}


?>

<html>
<body>
<h1>Aktulle Seite: <?php echo $_SESSION["aktuelleSeite"]; ?></h1>
<?php
    //ToDo: Erzeugen des Seiteninhalts über Datenbankzugriffe;
    echo "Inhalt der Seite ".$_SESSION["aktuelleSeite"]." von " .$_SESSION["anzahlSeiten"];
?>

<form action="" method="post">
    <input type="submit" name="vorherigeFrage" value="Vorherige Frage"
    <?php
        if($_SESSION["aktuelleSeite"] ==  1){
            echo " disabled ";
        }
    ?>
    >
    <input type="submit" name="naechsteFrage" value="Nächste Frage"
    <?php
            if($_SESSION["aktuelleSeite"] ==  $_SESSION["anzahlSeiten"]){
                echo " disabled ";
            }
    ?>
    >
</form>

</body>
 

</html>
