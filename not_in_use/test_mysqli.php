<!DOCTYPE html>
<html>
    <head>Die Klasse mysqli</head>
    <body>
        
        <?php
        $db = new mysqli ("localhost", "root", "", "o8EGaVZh9F");

        //SQL-Befehl testen
        if ($db->query("insert into student values"."('3234567', 'Fabrice Armbruster', 'WWI318')") == false){
            echo "Fehler";
            echo  $db->error;       //Erroor Message anzeigen lassen/ausgeben
        }
        else{
            echo "Alles hat funktioniert";
        }

        // $Q ist ein objekt --> fetch objet lifert false, wenn kein weitere datensatz da ist. 
        // bei fetch-Objekt wird über den attributzugriff auf die einzelnen werte zugregriffen 
        $q = $db->query("select * from benutzer");
        while(($s = $q-> fetch_object()) != false){
            echo $s->Benutzername. " " .$s->Passwort."<br/>";
        }


        //DB-Verbindung schließen. Ist jedoch nicht umbedingt nötig, da dies auch automatisch passiert. 
        $db->close();

        ?>

    </body>
</html>