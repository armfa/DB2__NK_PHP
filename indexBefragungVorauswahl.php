<?php
//Fabrice Armbruster

//________________________BESCHREIBUNG______________________
//Diese Seite dient als Vorauswahl, auf der der Student die für ihn 
//freigeschalteten und noch nicht abgegebenen Umfragen aufrufen kann. 

include_once 'classes/dbh.class.php';

//Diese Seite akzeptiert nur Studenten
if (isset($_SESSION['matrikelnummer']) == false) {
    //Falls Student nicht eingeloggt wird dieser auf die index-Seite weitergeleitet.
    //Ist dieser dort auch nicht eingeloggt auf die Login-Seite. 
    header("Location: ../DB2__NK_PHP/index.php");
    exit();
}
?>

<!doctype HTML>
<html>

<body>
    <!--Link um zurück auf die Startseite zu kommen bzw. Logout-->
    <header style="background-color:lightGray;">
        <ul>
            <li><a href="index.php">Zurück zur Startseite</a></li>
            <li><a href="indexLogin.php">Logout</a></li>
        </ul>
    </header>
    
    <h1>Welche Umfrage möchten Sie starten?</h1>

    <?php
    if (isset($_GET['k'])) {
        echo "<p class='success'>Sie haben den Fragebogen erfolgreich abgeschickt!</p>";
    }

            //Dropdownauswahl des Fragebogens, welcher für diesen Student freigeschalten ist.     
            $befragung = new Befragung();
            //Alle Fragebögen des Studenten, die abgegeben sind. 
            $fragebogen = $befragung->getFragebogenfromStudentAbgabestatusStnmt($_SESSION['matrikelnummer'], 1);
            //Alle Fragebögen die für den Studenten freigeschaltet sind, unabhängig der  bearbeitung oder abgabe
            $fragebogen2 = $befragung->getFragebogenfromStudent($_SESSION['matrikelnummer']);
            //Arrays vergleichen (MINUS) -> Unterschiede werden angezeigt
            //Sind sie gleich groß? -> Dann sind alle Bedfragungen schon abgegeben!
            if(count($fragebogen) != count($fragebogen2)){
                foreach ($fragebogen2 as $singleArray) {
                //Nach selben DS im anderen Array suchen
/*                 echo "Array-Ebene 1 ";
                print_r($singleArray);
                echo "</br>"; */
                if(count($fragebogen) != 0){
                       foreach($fragebogen as $compareArray){
/*                     echo "Array-Ebene 2 ";
                    print_r($compareArray);
                    echo "</br>"; */
                    //prüfen ob es keine treffer gibt
                    if(count(array_diff_assoc($singleArray, $compareArray)) != 0){
                        //Wenn es kein Treffer hat -> noch nicht abgegeben in array!
                        $resultx[] = $singleArray;
                        $buttonactive = 1;
                    } 
                }
                }
                else{
                    $resultx[] = $singleArray;
                    $buttonactive = 1;
                }
            }
            }
            else{
                $buttonactive = 0;
            }
?>

<?php
if($buttonactive == 1){

    echo '<form action="indexBefragung.php" method="post">';
        echo '<select name="fragebogen">';
            
            $i = 0;
            while ($i < count($resultx)) {
                echo "<option value='" . $resultx[$i]['Kuerzel'] . "'>" . $resultx[$i]['Titel'] . "</option>";
                $i++;
            }
            
        echo '</select></br></br>

        <button type="submit" name="umfrageStarten">Umfrage starten</button></form>';    
}
if($buttonactive == 0);
{
    echo "Super, du hast schon alle Umfragen beantwortet!";
}
?>
</body>
<?php
?>

</html>