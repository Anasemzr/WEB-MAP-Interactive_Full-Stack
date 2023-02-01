<?php
require_once 'connect-PDO.php';

$pseudo = $_GET['pseudo'];

$pseudoEquals = $dbh->query("SELECT * from ACCOUNT where pseudo = '$pseudo'");
$pseudoAlreadyExist = $pseudoEquals->fetch();

if($pseudoAlreadyExist)  $pseudoValidity = array("pseudoAlreadyExist"=>true);
else $pseudoValidity = array("pseudoAlreadyExist"=>false);
    
echo json_encode($pseudoValidity);
?>