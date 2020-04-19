<?php

  include_once 'classes/dbh.class.php';
  include_once 'classes/kurs.class.php';
  include_once 'classes/kursController.php';
  include_once 'classes/kursView.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hochschule Umfragen</title>
    <style>
    
    h1 {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 25pt;
        color: white;
    }
    p {
    	text-align: center; 
    	color: green;
    }
    .navigation{
        text-align: left;
        margin-left: 10rem;
        margin-right: 10rem;
        margin-top: 1rem; 
        margin-bottom: 1rem;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15pt;
        background-color: lightgrey;
    }
    .topHeader{
        text-align: center;
        margin-left: 10rem;
        margin-right: 10rem;
        margin-top: 3rem; 
        margin-bottom: 2rem;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 25pt;
        background-color: #c93838;
    }
    </style>
</head>
<body>
    <div class = topHeader>
    <h1>Herzlich Willkommen im Befragungstool, was möchten Sie tun?</h1> 
    </div>  
 </p>
 <div>
    <div class = navigation>
       <a href="indexKurs.php">Kurs anlegen</a>
    </div>
    <div class = navigation>
          <a href="indexLogin.php">Login</a>
    </div>
    <div class = navigation>
        <a href="indexErgebnis.php">Ergebnis</a>
    </div>
 </div>

  
</body>
</html>