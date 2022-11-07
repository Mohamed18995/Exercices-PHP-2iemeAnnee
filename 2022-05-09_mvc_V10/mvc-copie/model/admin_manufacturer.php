<?php
verifConnexion();
include_once("lib/manufacturer.php");

$url_page = "admin_manufacturer";


// récupération/initialisation du paramètre "action" qui va permettre de diriger dans le switch vers la partie de code qui sera a exécuter
// si aucune action n'est définie via le paramètre _GET alors l'action "liste" sera attribuée par défaut
$get_action = isset($_GET["action"]) ? filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) : "liste";


// récupération des informations passée en _GET pour cette partie du code (affichage de la liste + détail d'un manufacturer)
$get_id     = isset($_GET["id"])    ? filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS)      : null;
$get_alpha  = isset($_GET["alpha"]) ? filter_input(INPUT_GET, 'alpha', FILTER_SANITIZE_SPECIAL_CHARS)   : "A";

// switch sur la variable action afin d'exécuter telle ou telle partie de code
switch($get_action){
    // dans ce cas-ci, on désire générer la liste des manufacturer ordonnée par ordre alphabétique et filtré par initiale
    case "liste":

        // définition de la variable view qui sera utilisée dans la partie <body> du html pour afficher une certaine partie du code
        $page_view = "manufacturer_liste";
        // génération du tableau contenant toutes les lettres de l'alphabet et qui sera utilisée dans la partie affichage (switch(view) => pagination)
        $alphabet = range('A', 'Z');

        $result = getManufacturer(0, $get_alpha);

        // si le paramètre id n'est pas null et qu'il est numérique alors cela veut dire qu'il est demandé d'afficher le détail d'un manufacturer en particulier
        if(!is_null($get_id) && is_numeric($get_id)){
            // utilisation de la fonction getManufacturer pour récupérer un manufacturer en particulier
            $result_detail = getManufacturer($get_id);
            // interrogation de la variable (array) result_detail pour en extraire les données récupérées et les attribuer à des variables qui seront utilisée dans la partie affichage (switch(view) => pagination)
            $detail_manufacturer   = $result_detail[0]["manufacturer"];
            $detail_description    = $result_detail[0]["description"];
            // paramètre permettant de "dire" si il faut oui ou non afficher un détail dans la partie affichage
            $show_description = true;
        }
        break;

    // dans ce cas-ci, on désire ajouter un manufacturer
    // deux cas de figure :
    // 1) présentation du formulaire (en utilisant les fonctions de form)
    // 2) insertion des données dans la DB et affichage d'un message de succès ou d'erreur à l'utilisateur
    case "add":
        // récupération / initialisation des données qui transitent via le formulaire
        $post_manufacturer        = isset($_POST["manufacturer"])   ? filter_input(INPUT_POST, 'manufacturer', FILTER_SANITIZE_SPECIAL_CHARS)             : null;
        $post_description   = isset($_POST["description"])  ? filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS)    : null;

        // initialisation du array qui contiendra la définitions des différents champs du formulaire
        $input = [];
        // ajout des différents champs du formulaire
        $input[] = addLayout("<h4>Ajouter d'un manufacturer</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput('Manufacture', ["type" => "text", "value" => $post_manufacturer, "name" => "manufacturer", "class" => "u-full-width"], true, "twelve columns");
        $input[] = addLayout("</div>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addTextarea('Parcours / profil', array("name" => "description", "class" => "u-full-width"), $post_description, true, "twelve columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");
        // appel de la fonction form qui est chargée de générer le formulaire à partir du array de définition des champs $input ainsi que de la vérification de la validitée des données si le formulaire été soumis
        $show_form = form("form_contact", "index.php?p=".$url_page."&action=add", "post", $input);
        // si form() ne retourne pas false et retourne un string alors le formulaire doit être affiché
        if($show_form != false){
            // définition de la variable view qui sera utilisée pour afficher la partie du <body> du html nécessaire à l'affichage du formulaire
            $page_view = "manufacturer_form";

            // si form() retourne false, l'insertion peut avoir lieu
        }else{
            // création d'un tableau qui contiendra les données à passer à la fonction d'insert
            $data_values                    = array();
            $data_values["manufacturer"]    = $post_manufacturer;
            $data_values["description"]     = $post_description;
            // exécution de la requête
            if(insertManufacturer($data_values)){
                // message de succes qui sera affiché dans le <body>
                $msg = "<p>données insérées avec succès</p>";
                $msg_class = "success";
            }else{
                // message d'erreur qui sera affiché dans le <body>
                $msg = "<p>erreur lors de l'insertion des données</p>";
                $msg_class = "error";
            }
            // on demande à afficher la liste des manufacturers
            $page_view = "manufacturer_liste";
            // pour afficher cette liste, on a besoin de les récupérer au préalable dans la db
            $result = getManufacturer(0, $get_alpha);
            // génération du tableau contenant toutes les lettres de l'alphabet et qui sera utilisée dans la partie affichage (switch(view) => pagination)
            $alphabet = range('A', 'Z');
            //
            // si le paramètre id n'est pas null et qu'il est numérique alors cela veut dire qu'il est demandé d'afficher le détail d'un manufacturer en particulier
            if(!is_null($get_id) && is_numeric($get_id)){
                // utilisation de la fonction getManufacturer pour récupérer l'info du manufacturer précédemment sélectionné
                $result_detail = getManufacturer($get_id);
                // interrogation de la variable (array) result_detail pour en extraire les données récupérées et les attribuer à des variables qui seront utilisée dans la partie affichage (switch(view) => pagination)
                $detail_manufacturer   = $result_detail[0]["manufacturer"];
                $detail_description    = $result_detail[0]["description"];
                // paramètre permettant de "dire" si il faut oui ou non afficher un détail dans la partie affichage
                $show_description = true;
            }
        }
        break;

    case "update":
        // récupération avec filtre de netoyage FILTER_SANITIZE_NUMBER_INT
        $get_manufacturer_id = isset($_GET["manufacturer_id"]) ? filter_input(INPUT_GET, 'manufacturer_id', FILTER_SANITIZE_NUMBER_INT) : null;

        // récupération des données correspondant uniquement dans le cas du premier affichage du formulaire
        if(empty($_POST)){
            // récupération des infos dans la DB en utilisant l'id récupéré en GET
            $result = getManufacturer($get_manufacturer_id);

            $manufacturer      = $result[0]["manufacturer"];
            $description    = $result[0]["description"];
        }else{
            $manufacturer      = null;
            $lastname       = null;
            $description    = null;
        }

        // récupération / initialisation des données qui transitent via le formulaire
        $post_manufacturer        = isset($_POST["manufacturer"])   ? filter_input(INPUT_POST, 'manufacturer', FILTER_SANITIZE_SPECIAL_CHARS)             : $manufacturer;
        $post_description   = isset($_POST["description"])  ? filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS)    : $description;

        // initialisation du array qui contiendra la définitions des différents champs du formulaire
        $input = [];
        // ajout des différents champs du formulaire
        $input[] = addLayout("<h4>Modifier un manufacturer</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput('Manufacture', ["type" => "text", "value" => $post_manufacturer, "name" => "manufacturer", "class" => "u-full-width"], true, "twelve columns");
        $input[] = addLayout("</div>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addTextarea('Parcours / profil', array("name" => "description", "class" => "u-full-width"), $post_description, true, "twelve columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");
        // appel de la fonction form qui est chargée de générer le formulaire à partir du array de définition des champs $input ainsi que de la vérification de la validitée des données si le formulaire été soumis
        $show_form = form("form_contact", "index.php?p=".$url_page."&action=update&manufacturer_id=".$get_manufacturer_id."&id=".$get_id."&alpha=".$get_alpha, "post", $input);

        if($show_form != false){
            // définition de la variable view qui sera utilisée pour afficher la partie du <body> du html nécessaire à l'affichage du formulaire
            $page_view = "manufacturer_form";
        }else{
            $data_values                 = array();
            $data_values["manufacturer"] = $post_manufacturer;
            $data_values["description"]  = $post_description;

            if(updateManufacturer($get_manufacturer_id, $data_values)){
                // message de succes qui sera affiché dans le <body>
                $msg = "<p>données modifiée avec succès</p>";
                $msg_class = "success";
            }else{
                // message d'erreur qui sera affiché dans le <body>
                $msg = "<p>erreur lors de la modification des données</p>";
                $msg_class = "error";
            }
            // on demande à afficher la liste des manufacturers
            $page_view = "manufacturer_liste";
            // pour afficher cette liste, on a besoin de les récupérer au préalable dans la db
            $result = getManufacturer(0, $get_alpha);
            // génération du tableau contenant toutes les lettres de l'alphabet et qui sera utilisée dans la partie affichage (switch(view) => pagination)
            $alphabet = range('A', 'Z');
            //
            // si le paramètre id n'est pas null et qu'il est numérique alors cela veut dire qu'il est demandé d'afficher le détail d'un manufacturer en particulier
            if(!is_null($get_id) && is_numeric($get_id)){
                // utilisation de la fonction getManufacturer pour récupérer l'info du manufacturer précédemment sélectionné
                $result_detail = getManufacturer($get_id);
                // interrogation de la variable (array) result_detail pour en extraire les données récupérées et les attribuer à des variables qui seront utilisée dans la partie affichage (switch(view) => pagination)
                $detail_manufacturer         = $result_detail[0]["manufacturer"];
                $detail_nom            = $result_detail[0]["nom"];
                $detail_description    = $result_detail[0]["description"];
                // paramètre permettant de "dire" si il faut oui ou non afficher un détail dans la partie affichage
                $show_description = true;
            }
        }

        break;

    case "showHide":
        // récupération avec filtre de netoyage FILTER_SANITIZE_NUMBER_INT
        $get_manufacturer_id = isset($_GET["manufacturer_id"]) ? filter_input(INPUT_GET, 'manufacturer_id', FILTER_SANITIZE_NUMBER_INT) : null;

        if(showHideManufacturer($get_manufacturer_id)){
            // message de succes qui sera affiché dans le <body>
            $msg = "<p>mise à jour de l'état réalisée avec succès</p>";
            $msg_class = "success";
        }else{
            // message d'erreur qui sera affiché dans le <body>
            $msg = "<p>erreur lors de la mise à jour de l'état</p>";
            $msg_class = "error";
        }

        // on demande à afficher la liste des manufacturers
        $page_view = "manufacturer_liste";
        // pour afficher cette liste, on a besoin de les récupérer au préalable dans la db
        $result = getManufacturer(0, $get_alpha);
        // génération du tableau contenant toutes les lettres de l'alphabet et qui sera utilisée dans la partie affichage (switch(view) => pagination)
        $alphabet = range('A', 'Z');
        //
        // si le paramètre id n'est pas null et qu'il est numérique alors cela veut dire qu'il est demandé d'afficher le détail d'un manufacturer en particulier
        if(!is_null($get_id) && is_numeric($get_id)){
            // utilisation de la fonction getManufacturer pour récupérer l'info du manufacturer précédemment sélectionné
            $result_detail = getManufacturer($get_id);
            // interrogation de la variable (array) result_detail pour en extraire les données récupérées et les attribuer à des variables qui seront utilisée dans la partie affichage (switch(view) => pagination)
            $detail_manufacturer   = $result_detail[0]["manufacturer"];
            $detail_description    = $result_detail[0]["description"];
            // paramètre permettant de "dire" si il faut oui ou non afficher un détail dans la partie affichage
            $show_description = true;
        }

        break;
}

?>