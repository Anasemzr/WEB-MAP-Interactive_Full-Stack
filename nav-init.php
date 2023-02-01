<?php
    session_start();
    $array = array('email' => $_SESSION['email'], 'pseudo' => $_SESSION['pseudo']);
    echo json_encode( $array);
?>