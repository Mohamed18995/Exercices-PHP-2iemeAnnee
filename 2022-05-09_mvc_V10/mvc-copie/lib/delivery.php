<?php
function getDelivery($id = 0){
    if(!is_numeric($id)){
        return false;
    }
    // création de la condition WHERE en fonctions des infos passées en paramètre
    $cond = $id > 0 ? " delivery_id = ".$id : " 1 ";

    // requete permettant de récupérer les deliverys suivant le(s) filtre(s)
    $sql = "SELECT delivery_id, delivery, is_visible 
            FROM delivery 
            WHERE ".$cond." 
            ORDER BY delivery ASC;";

    // envoi de la requete vers le serveur de DB et stockaqge du résultat obtenu dans la variable result (array qui contiendra toutes les données récupérées)
    // renvoi de l'info
    return requeteResultat($sql);
}

function insertDelivery($data){
    $delivery    = $data["delivery"];
    $description    = $data["description"];

    $sql = "INSERT INTO delivery
                        (delivery) 
                    VALUES
                        ('$delivery');
                    ";
    // exécution de la requête
    return ExecRequete($sql);
}

function updateDelivery($id, $data){
    if(!is_numeric($id)){
        return false;
    }

    $delivery    = $data["delivery"];
    $description    = $data["description"];

    $sql = "UPDATE delivery 
                SET 
                    delivery = '".$delivery."' 
            WHERE delivery_id = ".$id.";
            ";
    // exécution de la requête
    return ExecRequete($sql);
}

function showHideDelivery($id){
    if(!is_numeric($id)){
        return false;
    }
    // récupération de l'état avant mise à jour
    $sql = "SELECT is_visible FROM delivery WHERE delivery_id = ".$id.";";
    $result = requeteResultat($sql);
    if(is_array($result)){
        $etat_is_visble = $result[0]["is_visible"];

        $nouvel_etat = $etat_is_visble == "1" ? "0" : "1";
        // mise à jour vers le nouvel état
        $sql = "UPDATE delivery SET is_visible = '".$nouvel_etat."' WHERE delivery_id = ".$id.";";
        // exécution de la requête
        return ExecRequete($sql);

    }else{
        return false;
    }
}

?>