<?php
include_once("lib/login.php");

$msg = "";

$post_login 	= isset($_POST["login"])    	? filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS) 		: null;
$post_password 	= isset($_POST["password"])  	? filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS)	: null;

// appel du formulaire via la fonction
$show_form = loginForm($post_login, $post_password);



if($show_form != false){
	$page_view = "login_form";
}else{
	// vérification
	$verifAcces = verifLogin($post_login, $post_password);
	if(is_array($verifAcces) && isset($verifAcces[0]["admin_id"])){
		// autoriser accès
		$_SESSION["admin_id"] 	= $verifAcces[0]["admin_id"];
		$_SESSION["pseudo"] 	= $verifAcces[0]["pseudo"];
		$page_view = "admin_home";
	}else{
		// réinitialisation de la superglobale post
		$_POST = [];
		// réafficher le formulaire avec message d'erreur
		$msg = "<p>Ce compte n'a pas été trouvé !</p>";
		$show_form = loginForm($post_login, $post_password);
		$page_view = "login_form";
	}
}
?>
















