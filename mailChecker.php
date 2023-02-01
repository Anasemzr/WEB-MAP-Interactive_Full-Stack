<?php
require_once 'connect-PDO.php';

$email = $_GET['email'];

$emailEquals = $dbh->query("SELECT * from ACCOUNT where email = '$email'");
$emailAlreadyExist = $emailEquals->fetch();

if($emailAlreadyExist)  $emailValidity = array("emailAlreadyExist"=>true);
else $emailValidity = array("emailAlreadyExist"=>false);
    
echo json_encode($emailValidity);
?>