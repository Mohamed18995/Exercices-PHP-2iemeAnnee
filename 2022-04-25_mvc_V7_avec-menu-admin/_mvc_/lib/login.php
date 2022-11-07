<?php
function verifLogin($login, $password){
	$sql = "SELECT admin_id, pseudo 
			FROM admin 
			WHERE login LIKE '$login' AND password LIKE MD5('$password');";
	return requeteResultat($sql);
}

function loginForm($login_value, $pass_value){
	// création du formulaire
	$input = [];
	// ajout des différents champs du formulaire
	$input[] = addInput("Votre identifiant", ["type"=>"email","name"=>"login","value"=>$login_value], true);
	$input[] = addInput("Votre mot-de-passe", ["type"=>"password", "name"=>"password", "value"=>$pass_value], true);
	$input[] = addSubmit(["name"=>"submit", "value"=>"connexion"], "");
	
	return form("form_login", "index.php?p=login", "post", $input);
}
?>