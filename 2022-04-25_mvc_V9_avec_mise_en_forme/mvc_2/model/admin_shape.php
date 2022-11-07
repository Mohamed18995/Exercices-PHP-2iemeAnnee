<?php
verifConnexion();
include_once("lib/shape.php");

$url_page = "admin_shape";

// récupération/initialisation du paramètre "action" qui va permettre de diriger dans le switch vers la partie de code qui sera a exécuter
// si aucune action n'est définie via le paramètre _GET alors l'action "liste" sera attribuée par défaut
$get_action     = isset($_GET["action"]) ? $_GET["action"] : "list";
// récupération des informations passées en _GET
$get_shape_id   = isset($_GET["shape_id"]) ? filter_input(INPUT_GET, 'shape_id', FILTER_SANITIZE_NUMBER_INT) : null;
$get_alpha      = isset($_GET["alpha"]) ? filter_input(INPUT_GET, 'alpha', FILTER_SANITIZE_SPECIAL_CHARS)   : "A";


switch($get_action){
    case "list":
        // récupération des shape correspondant
        $result = getShape();

        $page_view = "shape_liste";
        break;

    case "add":
        // récupération / initialisation des données qui transitent via le formulaire
        $post_shape_title = isset($_POST["shape_title"]) ? filter_input(INPUT_POST, 'shape_title', FILTER_SANITIZE_SPECIAL_CHARS) : null;
        $post_description = isset($_POST["description"]) ? filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS) : null;

        // initialisation du array qui contiendra la définitions des différents champs du formulaire
        $input = [];
        // ajout des différents champs du formulaire
        $input[] = addLayout("<h4>Ajouter d'un état</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput("Etat", ["type" => "text", "value" => $post_shape_title, "name" => "shape_title", "class" => "u-full-width"], true, "four columns");
        $input[] = addTextarea('Description', array("name" => "description", "class" => "u-full-width"), $post_description, true, "eight columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");
        // appel de la fonction form qui est chargée de générer le formulaire à partir du array de définition des champs $input ainsi que de la vérification de la validitée des données si le formulaire été soumis
        $show_form = form("form_contact", "index.php?p=".$url_page."&action=add", "post", $input);
        // si form() ne retourne pas false et retourne un string alors le formulaire doit être affiché
        if($show_form != false){
            // définition de la variable view qui sera utilisée pour afficher la partie du <body> du html nécessaire à l'affichage du formulaire
            $page_view = "shape_form";

            // si form() retourne false, l'insertion peut avoir lieu
        }else{
            // création d'un tableau qui contiendra les données à passer à la fonction d'insert
            $data_values = array();
            $data_values["shape_title"] = $post_shape_title;
            $data_values["description"] = $post_description;
            // exécution de la requête
            if(insertShape($data_values)){
                // message de succes qui sera affiché dans le <body>
                $msg = "<p>données insérées avec succès</p>";
                $msg_class = "success";
            }else{
                // message d'erreur qui sera affiché dans le <body>
                $msg = "<p>erreur lors de l'insertion des données</p>";
                $msg_class = "error";
            }

            // récupération des shape correspondant
            $result = getShape();

            $page_view = "shape_liste";
        }
        break;

    case "update":

        if(empty($_POST)){
            $result = getShape($get_shape_id);

            $post_shape_title = $result[0]["shape_title"];
            $post_description = $result[0]["description"];
        }else{
            // récupération / initialisation des données qui transitent via le formulaire
            $post_shape_title = isset($_POST["shape_title"]) ? filter_input(INPUT_POST, 'shape_title', FILTER_SANITIZE_SPECIAL_CHARS) : null;
            $post_description = isset($_POST["description"]) ? filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS) : null;
        }



        // initialisation du array qui contiendra la définitions des différents champs du formulaire
        $input = [];
        // ajout des différents champs du formulaire
        $input[] = addLayout("<h4>Modifier un shape</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput('Etat', ["type" => "text", "value" => $post_shape_title, "name" => "shape_title", "class" => "u-full-width"], true, "four columns");
        $input[] = addTextarea('Description', array("name" => "description", "class" => "u-full-width"), $post_description, true, "eight columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");
        // appel de la fonction form qui est chargée de générer le formulaire à partir du array de définition des champs $input ainsi que de la vérification de la validitée des données si le formulaire été soumis
        $show_form = form("form_contact", "index.php?p=".$url_page."&action=update&shape_id=".$get_shape_id, "post", $input);
        // si form() ne retourne pas false et retourne un string alors le formulaire doit être affiché
        if($show_form != false){
            // définition de la variable view qui sera utilisée pour afficher la partie du <body> du html nécessaire à l'affichage du formulaire
            $page_view = "shape_form";

            // si form() retourne false, l'insertion peut avoir lieu
        }else{
            $data_values = array();
            $data_values["shape_title"] = $post_shape_title;
            $data_values["description"] = $post_description;
            // exécution de la requête
            if(updateShape($get_shape_id, $data_values)){
                // message de succes qui sera affiché dans le <body>
                $msg = "<p>données modifiées avec succès</p>";
                $msg_class = "success";
            }else{
                // message d'erreur qui sera affiché dans le <body>
                $msg = "<p>erreur lors de la modification des données</p>";
                $msg_class = "error";
            }

            // récupération des shape correspondant
            $result = getShape();

            $page_view = "shape_liste";
        }


        break;

    case "showHide":
        if(showHideShape($get_shape_id)){
            // message de succes qui sera affiché dans le <body>
            $msg = "<p>mise à jour de l'état réalisée avec succès</p>";
            $msg_class = "success";
        }else{
            // message d'erreur qui sera affiché dans le <body>
            $msg = "<p>erreur lors de la mise à jour de l'état</p>";
            $msg_class = "error";
        }

        // récupération des shape correspondant
        $result = getShape();

        $page_view = "shape_liste";

        break;
}

?>