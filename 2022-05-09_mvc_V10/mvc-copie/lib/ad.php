<?php
function getAd($id = null, $alpha = ""){

    if(is_null($id)){
        // création de la condition WHERE en fonctions des infos passées en paramètre
        $cond = !empty($alpha) ? "WHERE ad_title LIKE '".$alpha."%' " : "";
        $sql = "SELECT ad_id, category_level_2_id, shape_id, designer_id, manufacturer_id, ad_title, ad_description, ad_description_detail, price, price_htva, amount_tva, price_delivery, date_add, is_disponible, is_visible FROM ad ".$cond." ORDER BY ad_title;";
    }else{
        if(is_numeric($id)){
            $sql = "SELECT category_level_2_id, shape_id, designer_id, manufacturer_id, ad_title, ad_description, ad_description_detail, price, price_htva, amount_tva, price_delivery, date_add, is_disponible, is_visible  FROM ad WHERE ad_id = $id;";
        }
    }

    $result = requeteResultat($sql);
    return $result;
}

function getAdPagination($limit, $start, $alpha, $is_all = 0, $list_cat = false){
    $pc = strlen($alpha) > 1 ? "%" : "";
    $sql_where_or = strlen($alpha) > 1 ? " OR ad_title  LIKE '$pc$alpha%' " : "";
    $sql_where = ($alpha == "---all---") ? " 1=1 " :  "( ad_title LIKE '$pc$alpha%' $sql_where_or ) ";
    $sql_where_cat = "";
    if(is_array($list_cat)){
        foreach($list_cat as $cat_id){
            $sql_where_cat .= empty($sql_where_cat) ? "AND (a.category_id = $cat_id " : " OR a.category_id = $cat_id ";
        }
        $sql_where_cat .= !empty($sql_where_cat) ? ")" : "";
    }

    if($is_all == 0){
        $sql = "SELECT  a.ad_id, 
                        a.admin_id, 
                        a.designer_id, 
                        a.manufacturer_id, 
                        a.ad_title, 
                        a.ad_description, 
                        a.ad_description_detail, 
                        a.price, 
                        a.price_delivery, 
                        a.date_add, 
                        a.is_visible, 
                        b.level_2, 
                        c.level_1, 
                        COALESCE(NULLIF(CONCAT(d.firstname,' ',d.lastname), ''), '<small style=\"opacity:.5;\">- non précisé -</small>') as designer_name, 
                        COALESCE(NULLIF(manufacturer, ''), '<small style=\"opacity:.5;\">- non précisé -</small>') as manufacturer 
                FROM ad a 
                    JOIN category_level_2 b ON b.category_level_2_id = a.category_level_2_id 
                    JOIN category_level_1 c ON b.category_level_1_id = c.category_level_1_id 
                    JOIN designer d ON d.designer_id = a.designer_id 
                    JOIN manufacturer m ON m.manufacturer_id = a.manufacturer_id 
                WHERE 
                    $sql_where 
                    $sql_where_cat
                ORDER BY is_visible DESC, ad_title   
                LIMIT $start, $limit;";
    }else{
        $sql = "SELECT  COUNT(*) as nbre 
                FROM ad a
                WHERE 
                    $sql_where 
                    $sql_where_cat
                ;";
    }

    return requeteResultat($sql);
}

function insertAd($data){
    $category_level_2_id    = $data["category_level_2_id"];
    $shape_id               = $data["shape_id"];
    $designer_id            = $data["designer_id"];
    $manufacturer_id        = $data["manufacturer_id"];
    $ad_title               = $data["ad_title"];
    $ad_description         = $data["ad_description"];
    $ad_description_detail  = $data["ad_description_detail"];
    $price_htva             = $data["price"];
    $price_delivery         = $data["price_delivery"];

    $amount_tva = round($price_htva * 0.21, 2);
    $price = $price_htva + $amount_tva;

    // gestion de l'image
    $img = uploadImg($data["picture"], "upload/normal/");
    // redimensionnement
    resize("upload/normal/".$img["photo"], 160, "upload/thumb/th_".$img["photo"], "");


    $sql = "INSERT INTO ad
                (category_level_2_id, shape_id, designer_id, manufacturer_id, ad_title, ad_description, ad_description_detail, price, price_htva, amount_tva, price_delivery, admin_id, date_add) 
            VALUES
                ($category_level_2_id, $shape_id, $designer_id, $manufacturer_id, '$ad_title', '$ad_description', '$ad_description_detail', $price, $price_htva, $amount_tva, $price_delivery, ".$_SESSION['admin_id'].", NOW());
            ";

    // exécution de la requête
    return ExecRequete($sql);
}

function updateAd($id, $data){
    if(!is_numeric($id)){
        return false;
    }
    $category_level_2_id    = $data["category_level_2_id"];
    $shape_id               = $data["shape_id"];
    $designer_id            = $data["designer_id"];
    $manufacturer_id        = $data["manufacturer_id"];
    $ad_title               = $data["ad_title"];
    $ad_description         = $data["ad_description"];
    $ad_description_detail  = $data["ad_description_detail"];
    $price_htva             = $data["price"];
    $price_delivery         = $data["price_delivery"];

    $amount_tva = round($price_htva * 0.21, 2);
    $price = $price_htva + $amount_tva;

    $sql = "UPDATE ad 
                SET
                    category_level_2_id = $category_level_2_id, 
                    shape_id = $shape_id, 
                    designer_id = $designer_id, 
                    manufacturer_id = $manufacturer_id, 
                    ad_title = '$ad_title', 
                    ad_description = '$ad_description', 
                    ad_description_detail = '$ad_description_detail', 
                    price = $price, 
                    price_htva = $price_htva, 
                    amount_tva = $amount_tva, 
                    price_delivery = $price_delivery 
            WHERE ad_id = $id;
            ";

    return ExecRequete($sql);
}

function showHideAd($id){
    if(!is_numeric($id)){
        return false;
    }
    // récupération de l'état avant mise à jour
    $sql = "SELECT is_visible FROM ad WHERE ad_id = ".$id.";";
    $result = requeteResultat($sql);
    if(is_array($result)){
        $etat_is_visble = $result[0]["is_visible"];

        $nouvel_etat = $etat_is_visble == "1" ? "0" : "1";
        // mise à jour vers le nouvel état
        $sql = "UPDATE ad SET is_visible = '".$nouvel_etat."' WHERE ad_id = ".$id.";";
        // exécution de la requête
        return ExecRequete($sql);

    }else{
        return false;
    }
}

?>