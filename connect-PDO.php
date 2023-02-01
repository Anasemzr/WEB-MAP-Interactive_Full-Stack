<?php

$user = 'root';
$pass = 'root';
// Data Source Name
$dsn = 'mysql:host=localhost;dbname=web-map-bd';
try{
//Tentative de connexion : on crée un objet de la classe PDO
 $dbh= new PDO($dsn, $user, $pass);
//S'il y a des erreurs de connexion, un objet PDOException
//est lancé. On peut gérer l’exception si on le souhaite
}
catch (PDOException $e){
 print "Erreur ! :" . $e->getMessage() . "<br/>";
 die(); // Quitter le script
}

?>