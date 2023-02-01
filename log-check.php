<?php 
    require_once 'connect-PDO.php';
    session_start();
    if(!empty($_POST['EMAIL']) && !empty($_POST['PASSWORD']))
    {
        $email = $_POST['EMAIL']; 
        $password = $_POST['PASSWORD'];
                
        $email = strtolower($email);

        $result = $dbh->query("SELECT * from ACCOUNT where email = '$email'");
        $data = $result->fetch();
        if($data)
        {
            // Si le mail est bon niveau format
            if(filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                // Si le mot de passe est le bon    
                if($password==$data['password'])
                {
                    // On créer la session et on redirige sur landing.php
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['id_user'] = $data['id'];
                    $_SESSION['pseudo'] = $data['pseudo'];

                    header('Location: index.php'); die();
                }else{ header('Location: log-in.php?login_err=password'); die(); }
            }else{ header('Location: log-in.php?login_err=email'); die(); }
        }else{ header('Location: log-in.php?login_err=already'); die(); }
    }
    else{ header('Location: log-in.php'); die();} // si le formulaire est envoyé sans aucune données

    $dbh=NULL;
?>