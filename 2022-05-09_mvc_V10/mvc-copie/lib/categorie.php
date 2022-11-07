<?php
function getLevel1($id=0){

    $cond = $id > 0 ? " WHERE category_level_1_id = ".$id : "";
    $sql = "SELECT category_level_1_id, level_1, is_visible
            FROM category_level_1
            $cond;
            ";
    return requeteResultat($sql);
}





/*
function getLevel1($id = 0, $is_visible = ""){
    if(!is_numeric($id)){
        return false;
    }
    // création de la condition WHERE en fonctions des infos passées en paramètre
    $cond = $id > 0 ? " category_level_1_id = ".$id : " 1 ";
    $cond .= !empty($is_visible) ? " AND is_visible = '1'" : "";


    // requete permettant de récupérer les items suivant le(s) filtre(s)
    $sql = "SELECT category_level_1_id, level_1, is_visible 
            FROM category_level_1  
            WHERE ".$cond." 
            ORDER BY level_1;";

    return requeteResultat($sql);
}
*/

function getLevel2($id = 0, $is_visible = ""){
    if(!is_numeric($id)){
        return false;
    }
    // création de la condition WHERE en fonctions des infos passées en paramètre
    $cond = $id > 0 ? " category_level_2_id = ".$id : " 1 ";
    $cond .= !empty($is_visible) ? " AND is_visible = '1'" : "";


    // requete permettant de récupérer les items suivant le(s) filtre(s)
    $sql = "SELECT category_level_2_id, a.category_level_1_id, level_1, level_2, CONCAT(level_1,' > ',level_2) as full_level, a.is_visible 
            FROM category_level_2 a
                LEFT JOIN category_level_1 USING (category_level_1_id)
            WHERE ".$cond." 
            ORDER BY level_1, level_2;";

    // envoi de la requete vers le serveur de DB et stockaqge du résultat obtenu dans la variable result (array qui contiendra toutes les données récupérées)
    // renvoi de l'info
    return requeteResultat($sql);
}

function insertLevel1($data){
    $level_1 = $data["level_1"];
	
    $sql = "INSERT INTO category_level_1
                        (level_1) 
                    VALUES
                        ('$level_1');
                    ";
    // exécution de la requête
    return ExecRequete($sql);
}

function insertLevel2($data){
    $level_2 = $data["level_2"];
    $level_1_id = $data["level_1_id"];

    $sql = "INSERT INTO category_level_2
                        (category_level_1_id, level_2) 
                    VALUES
                        ($level_1_id, '$level_2');
                    ";
    // exécution de la requête
    return ExecRequete($sql);
}

function updateLevel1($id, $data){
    if(!is_numeric($id)){
        return false;
    }
    $level_1 = $data["level_1"];

    $sql = "UPDATE category_level_1 
                SET 
                    level_1 = '".$level_1."'
            WHERE category_level_1_id = ".$id.";
            ";
    // exécution de la requête
    return ExecRequete($sql);
}

function updateLevel2($id, $data){
    if(!is_numeric($id)){
        return false;
    }
    $level_2 = $data["level_2"];
    $level_1_id = $data["level_1_id"];

    $sql = "UPDATE category_level_2 
                SET 
                    level_2 = '".$level_2."',
                    category_level_1_id = '".$level_1_id."'
            WHERE category_level_2_id = ".$id.";
            ";
    // exécution de la requête
    return ExecRequete($sql);
}

function showHideLevel1($id){
    if(!is_numeric($id)){
        return false;
    }
    // récupération de l'état avant mise à jour
    $sql = "SELECT is_visible FROM category_level_1 WHERE category_level_1_id = ".$id.";";
    $result = requeteResultat($sql);
    if(is_array($result)){
        $etat_is_visble = $result[0]["is_visible"];
        
        $nouvel_etat = $etat_is_visble == "1" ? "0" : "1";
        // mise à jour vers le nouvel état
        $sql = "UPDATE category_level_1 SET is_visible = '".$nouvel_etat."' WHERE category_level_1_id = ".$id.";";
        // exécution de la requête
        return ExecRequete($sql);

    }else{
        return false;
    }
}

function showHideLevel2($id){
    if(!is_numeric($id)){
        return false;
    }
    // récupération de l'état avant mise à jour
    $sql = "SELECT is_visible FROM category_level_2 WHERE category_level_2_id = ".$id.";";
    $result = requeteResultat($sql);
    if(is_array($result)){
        $etat_is_visble = $result[0]["is_visible"];

        $nouvel_etat = $etat_is_visble == "1" ? "0" : "1";
        // mise à jour vers le nouvel état
        $sql = "UPDATE category_level_2 SET is_visible = '".$nouvel_etat."' WHERE category_level_2_id = ".$id.";";
        // exécution de la requête
        return ExecRequete($sql);

    }else{
        return false;
    }
}

?>