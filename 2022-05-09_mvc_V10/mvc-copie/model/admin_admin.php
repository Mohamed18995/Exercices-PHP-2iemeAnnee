<?php
verifConnexion();
include_once("lib/admin.php");

$url_page = "admin_admin";

// récupération/initialisation du paramètre "action" qui va permettre de diriger dans le switch vers la partie de code qui sera a exécuter
// si aucune action n'est définie via le paramètre _GET alors l'action "liste" sera attribuée par défaut
$get_action     = isset($_GET["action"]) ? $_GET["action"] : "list";
// récupération des informations passées en _GET
$get_admin_id   = isset($_GET["admin_id"]) ? filter_input(INPUT_GET, 'admin_id', FILTER_SANITIZE_NUMBER_INT) : null;
$get_alpha      = isset($_GET["alpha"]) ? filter_input(INPUT_GET, 'alpha', FILTER_SANITIZE_SPECIAL_CHARS)   : "A";


switch($get_action){
    case "list":
        // génération du tableau contenant toutes les lettres de l'alphabet et qui sera utilisée dans la partie affichage (switch(view) => pagination)
        $alphabet = range('A', 'Z');
        // récupération des admin correspondant
        $result = getAdmin(null, $get_alpha);

        $page_view = "admin_liste";
        break;

    case "add":
        // récupération / initialisation des données qui transitent via le formulaire
        $post_login = isset($_POST["login"]) ? filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS) : null;
        $post_password = isset($_POST["password"]) ? filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS) : null;
        $post_level_access = isset($_POST["level_access"]) ? filter_input(INPUT_POST, 'level_access', FILTER_SANITIZE_SPECIAL_CHARS) : null;
        $post_pseudo = isset($_POST["pseudo"]) ? filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS) : null;
        $post_street = isset($_POST["street"]) ? filter_input(INPUT_POST, 'street', FILTER_SANITIZE_SPECIAL_CHARS) : null;
        $post_num = isset($_POST["num"]) ? filter_input(INPUT_POST, 'num', FILTER_SANITIZE_SPECIAL_CHARS) : null;
        $post_zip = isset($_POST["zip"]) ? filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_SPECIAL_CHARS) : null;
        $post_city = isset($_POST["city"]) ? filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS) : null;

        // initialisation du array qui contiendra la définitions des différents champs du formulaire
        $input = [];
        // ajout des différents champs du formulaire
        $input[] = addLayout("<h4>Ajouter d'un admin</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput('Identifiant / E-mail', ["type" => "email", "value" => $post_login, "name" => "login", "class" => "u-full-width"], true, "four columns");
        $input[] = addInput('Mot-de-passe', ["type" => "password", "value" => $post_password, "name" => "password", "class" => "u-full-width"], true, "four columns");
        $input[] = addInput('Pseudo', ["type" => "text", "value" => $post_pseudo, "name" => "pseudo", "class" => "u-full-width"], true, "four columns");
        $input[] = addLayout("</div>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addRadioCheckbox('Niveau d\'acces', ["name" => $post_level_access], ["1" => "Super administrateur", "2" => "simple admin"], "2", true, "radio", "twelves columns");
        $input[] = addLayout("</div>");
        $input[] = addLayout("<h5>Adresse postale</h5>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput('Rue', array("type" => "text", "value" => $post_street, "name" => "street", "class" => "u-full-width"), true, "eight columns");
        $input[] = addInput('Numéro', array("type" => "text", "value" => $post_num, "name" => "num", "class" => "u-full-width"), true, "four columns");
        $input[] = addLayout("</div>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput('Code postal', array("type" => "text", "value" => $post_zip, "name" => "zip", "class" => "u-full-width"), true, "four columns");
        $input[] = addInput('Localité', array("type" => "text", "value" => $post_city, "name" => "city", "class" => "u-full-width"), true, "eight columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");
        // appel de la fonction form qui est chargée de générer le formulaire à partir du array de définition des champs $input ainsi que de la vérification de la validitée des données si le formulaire été soumis
        $show_form = form("form_contact", "index.php?p=".$url_page."&action=add"."&alpha=".$get_alpha, "post", $input);
        // si form() ne retourne pas false et retourne un string alors le formulaire doit être affiché
        if($show_form != false){
            // définition de la variable view qui sera utilisée pour afficher la partie du <body> du html nécessaire à l'affichage du formulaire
            $page_view = "admin_form";

            // si form() retourne false, l'insertion peut avoir lieu
        }else{
            // création d'un tableau qui contiendra les données à passer à la fonction d'insert
            $data_values = array();
            $data_values["login"] = $post_login;
            $data_values["password"] = $post_password;
            $data_values["level_access"] = $post_level_access;
            $data_values["street"] = $post_street;
            $data_values["num"] = $post_num;
            $data_values["zip"] = $post_zip;
            $data_values["city"] = $post_city;
            $data_values["pseudo"] = $post_pseudo;
            // exécution de la requête
            if(insertAdmin($data_values)){
                // message de succes qui sera affiché dans le <body>
                $msg = "<p>données insérées avec succès</p>";
                $msg_class = "success";
            }else{
                // message d'erreur qui sera affiché dans le <body>
                $msg = "<p>erreur lors de l'insertion des données</p>";
                $msg_class = "error";
            }

            // génération du tableau contenant toutes les lettres de l'alphabet et qui sera utilisée dans la partie affichage (switch(view) => pagination)
            $alphabet = range('A', 'Z');
            // récupération des admin correspondant
            $result = getAdmin(null, $get_alpha);

            $page_view = "admin_liste";
        }
        break;

    case "update":

        if(empty($_POST)){
            $result = getAdmin($get_admin_id);

            $post_login = $result[0]["login"];
            $post_pseudo = $result[0]["pseudo"];
            $post_level_access = $result[0]["level_access"];
            $post_street = $result[0]["street"];
            $post_num = $result[0]["num"];
            $post_zip = $result[0]["zip"];
            $post_city = $result[0]["city"];
            $post_password = "";
        }else{
            // récupération / initialisation des données qui transitent via le formulaire
            $post_login = isset($_POST["login"]) ? filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS) : null;
            $post_password = isset($_POST["password"]) ? filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS) : null;
            $post_level_access = isset($_POST["level_access"]) ? filter_input(INPUT_POST, 'level_access', FILTER_SANITIZE_SPECIAL_CHARS) : null;
            $post_pseudo = isset($_POST["pseudo"]) ? filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS) : null;
            $post_street = isset($_POST["street"]) ? filter_input(INPUT_POST, 'street', FILTER_SANITIZE_SPECIAL_CHARS) : null;
            $post_num = isset($_POST["num"]) ? filter_input(INPUT_POST, 'num', FILTER_SANITIZE_SPECIAL_CHARS) : null;
            $post_zip = isset($_POST["zip"]) ? filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_SPECIAL_CHARS) : null;
            $post_city = isset($_POST["city"]) ? filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS) : null;
        }



        // initialisation du array qui contiendra la définitions des différents champs du formulaire
        $input = [];
        // ajout des différents champs du formulaire
        $input[] = addLayout("<h4>Modifier un admin</h4>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput('Identifiant / E-mail', ["type" => "email", "value" => $post_login, "name" => "login", "class" => "u-full-width"], true, "four columns");
        $input[] = addInput('Mot-de-passe', ["type" => "password", "value" => $post_password, "name" => "password", "class" => "u-full-width"], false, "four columns");
        $input[] = addInput('Pseudo', ["type" => "text", "value" => $post_pseudo, "name" => "pseudo", "class" => "u-full-width"], true, "four columns");
        $input[] = addLayout("</div>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addRadioCheckbox('Niveau d\'acces', ["name" => $post_level_access], ["1" => "Super administrateur", "2" => "simple admin"], "2", true, "radio", "twelves columns");
        $input[] = addLayout("</div>");
        $input[] = addLayout("<h5>Adresse postale</h5>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput('Rue', array("type" => "text", "value" => $post_street, "name" => "street", "class" => "u-full-width"), true, "eight columns");
        $input[] = addInput('Numéro', array("type" => "text", "value" => $post_num, "name" => "num", "class" => "u-full-width"), true, "four columns");
        $input[] = addLayout("</div>");
        $input[] = addLayout("<div class='row'>");
        $input[] = addInput('Code postal', array("type" => "text", "value" => $post_zip, "name" => "zip", "class" => "u-full-width"), true, "four columns");
        $input[] = addInput('Localité', array("type" => "text", "value" => $post_city, "name" => "city", "class" => "u-full-width"), true, "eight columns");
        $input[] = addLayout("</div>");
        $input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");
        // appel de la fonction form qui est chargée de générer le formulaire à partir du array de définition des champs $input ainsi que de la vérification de la validitée des données si le formulaire été soumis
        $show_form = form("form_contact", "index.php?p=".$url_page."&action=update&admin_id=".$get_admin_id."&alpha=".$get_alpha, "post", $input);
        // si form() ne retourne pas false et retourne un string alors le formulaire doit être affiché
        if($show_form != false){
            // définition de la variable view qui sera utilisée pour afficher la partie du <body> du html nécessaire à l'affichage du formulaire
            $page_view = "admin_form";

            // si form() retourne false, l'insertion peut avoir lieu
        }else{
            $data_values = array();
            $data_values["login"] = $post_login;
            $data_values["password"] = $post_password;
            $data_values["level_access"] = $post_level_access;
            $data_values["street"] = $post_street;
            $data_values["num"] = $post_num;
            $data_values["zip"] = $post_zip;
            $data_values["city"] = $post_city;
            $data_values["pseudo"] = $post_pseudo;
            // exécution de la requête
            if(updateAdmin($get_admin_id, $data_values)){
                // message de succes qui sera affiché dans le <body>
                $msg = "<p>données modifiées avec succès</p>";
                $msg_class = "success";
            }else{
                // message d'erreur qui sera affiché dans le <body>
                $msg = "<p>erreur lors de la modification des données</p>";
                $msg_class = "error";
            }

            // génération du tableau contenant toutes les lettres de l'alphabet et qui sera utilisée dans la partie affichage (switch(view) => pagination)
            $alphabet = range('A', 'Z');
            // récupération des admin correspondant
            $result = getAdmin(null, $get_alpha);

            $page_view = "admin_liste";
        }


        break;

    case "showHide":
        if(showHideAdmin($get_admin_id)){
            // message de succes qui sera affiché dans le <body>
            $msg = "<p>mise à jour de l'état réalisée avec succès</p>";
            $msg_class = "success";
        }else{
            // message d'erreur qui sera affiché dans le <body>
            $msg = "<p>erreur lors de la mise à jour de l'état</p>";
            $msg_class = "error";
        }

        // génération du tableau contenant toutes les lettres de l'alphabet et qui sera utilisée dans la partie affichage (switch(view) => pagination)
        $alphabet = range('A', 'Z');
        // récupération des admin correspondant
        $result = getAdmin(null, $get_alpha);

        $page_view = "admin_liste";

        break;
}

?>