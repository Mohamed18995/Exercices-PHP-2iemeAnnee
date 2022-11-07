<?php
verifConnexion();
include_once("lib/delivery.php");

$url_page = "admin_delivery";

// récupération/initialisation du paramètre "action" qui va permettre de diriger dans le switch vers la partie de code qui sera a exécuter
// si aucune action n'est définie via le paramètre _GET alors l'action "liste" sera attribuée par défaut
$get_action     = isset($_GET["action"]) ? $_GET["action"] : "list";
// récupération des informations passées en _GET
$get_delivery_id   = isset($_GET["delivery_id"]) ? filter_input(INPUT_GET, 'delivery_id', FILTER_SANITIZE_NUMBER_INT) : null;
$get_alpha      = isset($_GET["alpha"]) ? filter_input(INPUT_GET, 'alpha', FILTER_SANITIZE_SPECIAL_CHARS)   : "A";


switch($get_action){
    case "list":
        // récupération des delivery correspondant
        $result = getDelivery();

        $page_view = "delivery_liste";
        break;

    case "add":
        // récupération / initialisation des données qui transitent via le formulaire
        $post_delivery = isset($_POST["delivery"]) ? filter_input(INPUT_POST, 'delivery', FILTER_SANITIZE_SPECIAL_CHARS) : null;

        // initialisation du array qui contiendra la définitions des différents champs du formulaire
        $input = [];
        // ajout des différents champs du formulaire
        $input[] = addLayout("<h4>Ajouter d'un état</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput("Etat", ["type" => "text", "value" => $post_delivery, "name" => "delivery", "class" => "u-full-width"], true, "twelve columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");
        // appel de la fonction form qui est chargée de générer le formulaire à partir du array de définition des champs $input ainsi que de la vérification de la validitée des données si le formulaire été soumis
        $show_form = form("form_contact", "index.php?p=".$url_page."&action=add", "post", $input);
        // si form() ne retourne pas false et retourne un string alors le formulaire doit être affiché
        if($show_form != false){
            // définition de la variable view qui sera utilisée pour afficher la partie du <body> du html nécessaire à l'affichage du formulaire
            $page_view = "delivery_form";

            // si form() retourne false, l'insertion peut avoir lieu
        }else{
            // création d'un tableau qui contiendra les données à passer à la fonction d'insert
            $data_values = array();
            $data_values["delivery"] = $post_delivery;
            // exécution de la requête
            if(insertDelivery($data_values)){
                // message de succes qui sera affiché dans le <body>
                $msg = "<p>données insérées avec succès</p>";
                $msg_class = "success";
            }else{
                // message d'erreur qui sera affiché dans le <body>
                $msg = "<p>erreur lors de l'insertion des données</p>";
                $msg_class = "error";
            }

            // récupération des delivery correspondant
            $result = getDelivery();

            $page_view = "delivery_liste";
        }
        break;

    case "update":

        if(empty($_POST)){
            $result = getDelivery($get_delivery_id);

            $post_delivery = $result[0]["delivery"];
        }else{
            // récupération / initialisation des données qui transitent via le formulaire
            $post_delivery = isset($_POST["delivery"]) ? filter_input(INPUT_POST, 'delivery', FILTER_SANITIZE_SPECIAL_CHARS) : null;
        }



        // initialisation du array qui contiendra la définitions des différents champs du formulaire
        $input = [];
        // ajout des différents champs du formulaire
        $input[] = addLayout("<h4>Modifier un delivery</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput('Etat', ["type" => "text", "value" => $post_delivery, "name" => "delivery", "class" => "u-full-width"], true, "twelve columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");
        // appel de la fonction form qui est chargée de générer le formulaire à partir du array de définition des champs $input ainsi que de la vérification de la validitée des données si le formulaire été soumis
        $show_form = form("form_contact", "index.php?p=".$url_page."&action=update&delivery_id=".$get_delivery_id, "post", $input);
        // si form() ne retourne pas false et retourne un string alors le formulaire doit être affiché
        if($show_form != false){
            // définition de la variable view qui sera utilisée pour afficher la partie du <body> du html nécessaire à l'affichage du formulaire
            $page_view = "delivery_form";

            // si form() retourne false, l'insertion peut avoir lieu
        }else{
            $data_values = array();
            $data_values["delivery"] = $post_delivery;
            $data_values["description"] = $post_description;
            // exécution de la requête
            if(updateDelivery($get_delivery_id, $data_values)){
                // message de succes qui sera affiché dans le <body>
                $msg = "<p>données modifiées avec succès</p>";
                $msg_class = "success";
            }else{
                // message d'erreur qui sera affiché dans le <body>
                $msg = "<p>erreur lors de la modification des données</p>";
                $msg_class = "error";
            }

            // récupération des delivery correspondant
            $result = getDelivery();

            $page_view = "delivery_liste";
        }


        break;

    case "showHide":
        if(showHideDelivery($get_delivery_id)){
            // message de succes qui sera affiché dans le <body>
            $msg = "<p>mise à jour de l'état réalisée avec succès</p>";
            $msg_class = "success";
        }else{
            // message d'erreur qui sera affiché dans le <body>
            $msg = "<p>erreur lors de la mise à jour de l'état</p>";
            $msg_class = "error";
        }

        // récupération des delivery correspondant
        $result = getDelivery();

        $page_view = "delivery_liste";

        break;
}

?>