<?php
    include 'dbVerbindung.php';
    include 'neuerKurs.php';
    include 'neuerKursShow.php';
?>

<!doctype html>
<html>
<head>
        <title>Befragungstool</title>
</head>
<body>
    <?php
    $studenten = new neuerKursShow();
    $studenten->showAllStudents();
    ?>
</body>
</html>


<body>
<?php
($_POST);
if(isset($_POST["neuerKursAnlegen"])){
echo "Sie haben folgenden Kurs angelegt:".$_POST["kurs"];
}
?>

<form action="" method="post">

Kurs <input type="text" name="kurs"><br>
<p>Welche Studenten möchten Sie anlegen und dem Kurs hinzufügen?</p>
Student<input type="text" name="matrikelnummerStudent">
<input type="submit" name="studentHinzufügen" value="+"/><br>
<input type="submit" name="neuerKursAnlegen" value="Neuen Kurs anlegen"/>
</form>



</body>
</html>