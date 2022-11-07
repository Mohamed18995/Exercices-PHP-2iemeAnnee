<?php
// affichage de debugage -> print_r mis en forme
function print_q($val){
    echo "<pre style='background-color:#000;color:#3FBBD5;font-size:11px;z-index:99999;position:relative;'>";
    print_r($val);
    echo "</pre>";
}

function verifConnexion(){
	// vérifier si la session est active sinon retour au login
	if((!isset($_SESSION["admin_id"])) || (empty($_SESSION["admin_id"]))|| (!is_numeric($_SESSION["admin_id"]))){
		header("Location: index.php?p=login");
		exit;
	}
}

?>