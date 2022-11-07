<?php
verifConnexion();
include_once("lib/admin.php");
include_once("lib/designer.php");

$url_page = "admin_password";


// récupération / initialisation des données qui transitent via le formulaire
$post_password_old = isset($_POST["password_old"]) ? filter_input(INPUT_POST, 'password_old', FILTER_SANITIZE_SPECIAL_CHARS) : null;
$post_password_new = isset($_POST["password_new"]) ? filter_input(INPUT_POST, 'password_new', FILTER_SANITIZE_SPECIAL_CHARS) : null;
$post_password_cfm = isset($_POST["password_cfm"]) ? filter_input(INPUT_POST, 'password_cfm', FILTER_SANITIZE_SPECIAL_CHARS) : null;

$show_error_actuel_pw = false;
// contraintes
if(!empty($_POST)){
    $msg = "";
    // vérifier si le mot de passe actuel est bien correct sinon message d'erreur et réinitialisation de $post_password_old
    if(!empty($post_password_old)){
        if(getAdmin($_SESSION["admin_id"])[0]["password"] != md5($post_password_old)){
            $msg .= "<li>Le mot-de-passe actuel n'est pas correct !</li>";
            $post_password_old = null;
            $msg_class = "error";
        }
    }
    // idem pour la seconde contrainte où le nouveau mot-de-passe et la confirmation doivent être identiques
    if($post_password_new != $post_password_cfm){
        $post_password_new = null;
        $post_password_cfm = null;
        $msg .= "<li>Le nouveau mot-de-passe et la confirmation de celui-ci doivent être identiques !</li>";
        $msg_class = "error";
    }
	$msg = !empty($msg) ? $msg."<li><b>les champs incorrects vont être vidés</b></li>" : "";
}

// initialisation du array qui contiendra la définitions des différents champs du formulaire
$input = [];
// ajout des différents champs du formulaire
$input[] = addLayout("<h4>Modification du mot-de-passe</h4>");
$input[] = addLayout("<div class='row'>");
$input[] = addInput('Mot-de-passe actuel', ["type" => "password", "value" => $post_password_old, "name" => "password_old", "class" => "u-full-width"], true, "twelves columns");
$input[] = addLayout("</div>");
$input[] = addLayout("<div class='row'>");
$input[] = addInput('Nouveau mot-de-passe', ["type" => "password", "value" => $post_password_new, "name" => "password_new", "class" => "u-full-width"], true, "twelves columns");
$input[] = addLayout("</div>");
$input[] = addLayout("<div class='row'>");
$input[] = addInput('Confirmation du nouveau mot-de-passe', ["type" => "password", "value" => $post_password_cfm, "name" => "password_cfm", "class" => "u-full-width"], true, "twelves columns");
$input[] = addLayout("</div>");
$input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "\t\t<br />\n");
// appel de la fonction form qui est chargée de générer le formulaire à partir du array de définition des champs $input ainsi que de la vérification de la validitée des données si le formulaire été soumis
$show_form = form("form_contact", "index.php?p=".$url_page, "post", $input);




// si form() ne retourne pas false et retourne un string alors le formulaire doit être affiché
if($show_form != false){
    // définition de la variable view qui sera utilisée pour afficher la partie du <body> du html nécessaire à l'affichage du formulaire
    $page_view = "admin_newpassword_form";

    // si form() retourne false, l'insertion peut avoir lieu
}else{
    // création d'un tableau qui contiendra les données à passer à la fonction d'insert
    $data_values = array();
    // exécution de la requête


    if(updatePassword($post_password_new)){
        // message de succes qui sera affiché dans le <body>
        $msg = "<p>Mot-de-passe modifié avec succès</p>";
        $msg_class = "success";
    }else{
        // message d'erreur qui sera affiché dans le <body>
        $msg = "<p>erreur lors de la modification du mot-de-passe</p>";
        $msg_class = "error";
    }


    $page_view = "admin_newpassword_form";
}
?>