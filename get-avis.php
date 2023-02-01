<?php 
    require_once 'connect-PDO.php';
    
    if (!empty($_GET['id'])){
        try {
            $id_pdc = $_GET['id'];

            $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
            $query = $dbh->query("SELECT pseudo,contenu from avis where id_pdc = '$id_pdc' ");

            $array = array();
            
            if($query) {
                while($row = $query->fetch()){
                    array_push($array,[
                        'pseudo' => $row['pseudo'],
                        'contenu' => $row['contenu']
                    ]);            
                }
            }

            echo json_encode($array);

        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>