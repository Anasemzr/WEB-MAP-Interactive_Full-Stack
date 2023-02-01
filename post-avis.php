<?php 
    require_once 'connect-PDO.php';
    
    session_start();
    
    if(!empty($_POST['id_pdc']) && !empty($_POST['avisText'])){
        $id_pdc = $_POST['id_pdc'];
        $avis_text = $_POST['avisText'];

        $id_pdc= isset($_POST['id_pdc'])?($_POST['id_pdc']):'';
        $avis_text= isset($_POST['avisText'])?($_POST['avisText']):'';
        $pseudo= $_SESSION['pseudo'];

        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 

        $alreadyPosted = $dbh->query("SELECT * from avis where pseudo = '$pseudo' AND id_pdc = '$id_pdc' ");
        $avisAlreadyPosted = $alreadyPosted->fetch();

        if ($avisAlreadyPosted){
            $dbh->exec("DELETE FROM avis WHERE pseudo = '$pseudo' AND id_pdc = '$id_pdc' ");
            try {
                $dbh->exec("INSERT INTO avis(id_pdc,contenu,pseudo) VALUES ('$id_pdc','$avis_text','$pseudo')");
                header('Location: index.php?avisPostFormState=newAvis');
            }
            catch (PDOException $e){
                print "Erreur ! :" . $e->getMessage() ; "<br/>";
            }
            header('Location: index.php?avisPostFormState=editedAvis');
        }  
        else{
            try {
                $dbh->exec("INSERT INTO avis(id_pdc,contenu,pseudo) VALUES ('$id_pdc','$avis_text','$pseudo')");
                header('Location: index.php?avisPostFormState=newAvis');
            }
            catch (PDOException $e){
                print "Erreur ! :" . $e->getMessage() ; "<br/>";
            }
        }
    }


?>