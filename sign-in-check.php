<?php 
    require_once 'connect-PDO.php';

    if(!empty($_POST['PSEUDO']) && !empty($_POST['EMAIL']))
    {
        $pseudo = $_POST['PSEUDO']; 
        $email = $_POST['EMAIL'];
                
        $email = strtolower($email);

        $emailEquals = $dbh->query("SELECT * from ACCOUNT where email = '$email'");
        $emailAlreadyExist = $emailEquals->fetch();

        $pseudoEquals = $dbh->query("SELECT * from ACCOUNT where pseudo = '$pseudo'");
        $pseudoAlreadyExist = $pseudoEquals->fetch();

        if($emailAlreadyExist){//email déja inscrit
            header('Location: sign-in.php?sign-in_err=email'); die();
        }else if($pseudoAlreadyExist){//pseudo déja pris
            header('Location: sign-in.php?sign-in_err=pseudo'); 
        }
        else{//création de l'user   
            $pseudo= isset($_POST['PSEUDO'])?($_POST['PSEUDO']):'';
            $email= isset($_POST['EMAIL'])?($_POST['EMAIL']):'';
            $password= isset($_POST['PASSWORD1'])?($_POST['PASSWORD1']):'';

            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 

            try { 
                $dbh->exec("INSERT INTO ACCOUNT(pseudo,email,password) VALUES ('$pseudo','$email','$password')");
                header('Location: log-in.php?sign-in-success=true'); 
            }
            catch (PDOException $e){
                print "Erreur ! :" . $e->getMessage() ; "<br/>";
            }
            
        }
    }
    else{ header('Location: sign-in.php'); die();} // si le formulaire est envoyé sans aucune données

    $dbh=NULL;
?>