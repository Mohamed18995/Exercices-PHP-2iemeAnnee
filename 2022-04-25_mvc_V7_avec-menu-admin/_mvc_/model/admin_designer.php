<?php
// pour protéger par login et password
verifConnexion();
include_once("lib/designer.php");
$get_action 		= isset($_GET["action"]) 		? $_GET["action"] 		: "list";
$get_designer_id 	= isset($_GET["designer_id"]) 	? $_GET["designer_id"] 	: 0;

$msg = "";


switch($get_action){
	case "list":
		$recup_designer = getDesigner();
		$page_view = "admin_designer_list";
		
		break;
		
	case "add":
		$post_lastname 		= isset($_POST["lastname"])     ? filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS)       : null;
		$post_firstname     = isset($_POST["firstname"])    ? filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS)      : null;
		$post_description   = isset($_POST["description"])  ? filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS)    : null;
		
		
		// création du formulaire
		$input = [];
		// ajout des différents champs du formulaire
		$input[] = addInput('Nom', ["type" => "text", "value" => $post_lastname, "name" => "lastname", "class" => "u-full-width"], true, "six columns");
		$input[] = addInput('Prénom', ["type" => "text", "value" => $post_firstname, "name" => "firstname", "class" => "u-full-width"], true, "six columns");
		$input[] = addTextarea('Parcours du designer', ["name" => "description", "class" => "u-full-width"], $post_description, false);
		$input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "");
		
		$show_form = form("form_designer", "index.php?p=admin_designer&action=add", "post", $input); 
		
		if($show_form != false){
			$page_view = "admin_designer_form";
		}else{
			
			$data_value = array();
			$data_value["firstname"] 	= $post_firstname;
			$data_value["lastname"] 	= $post_lastname;
			$data_value["description"] 	= $post_description;
			
			$add = addDesigner($data_value);
			if($add){
				$msg = "<p>Designer ajouté avec succès</p>";
			}else{
				$msg = "<p>Erreur lors de l'ajout !</p>";
			}
			
			$recup_designer = getDesigner();
			$page_view = "admin_designer_list";
			
		}
		
		
		break;
		
	case "update":
		// récupération des données suivant l'id passé en paramètre
		$recup_designer = getDesigner($get_designer_id);
	
	
		$post_lastname 		= isset($_POST["lastname"])     ? filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS)       : $recup_designer[0]["lastname"];
		$post_firstname     = isset($_POST["firstname"])    ? filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS)      : $recup_designer[0]["firstname"];
		$post_description   = isset($_POST["description"])  ? filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS)    : $recup_designer[0]["description"];
		
		
		// création du formulaire
		$input = [];
		// ajout des différents champs du formulaire
		$input[] = addInput('Nom', ["type" => "text", "value" => $post_lastname, "name" => "lastname", "class" => "u-full-width"], true, "six columns");
		$input[] = addInput('Prénom', ["type" => "text", "value" => $post_firstname, "name" => "firstname", "class" => "u-full-width"], true, "six columns");
		$input[] = addTextarea('Parcours du designer', ["name" => "description", "class" => "u-full-width"], $post_description, false);
		$input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "");
		
		$show_form = form("form_designer", "index.php?p=admin_designer&action=update&designer_id=".$get_designer_id, "post", $input); 
		
		if($show_form != false){
			$page_view = "admin_designer_form";
		}else{
			$data_value = array();
			$data_value["firstname"] 	= $post_firstname;
			$data_value["lastname"] 	= $post_lastname;
			$data_value["description"] 	= $post_description;
			
			$update = updateDesigner($data_value, $get_designer_id);
			if($update){
				$msg = "<p>Designer mis à jour avec succès</p>";
			}else{
				$msg = "<p>Erreur lors de la mise à jour !</p>";
			}
			
			$recup_designer = getDesigner();
			$page_view = "admin_designer_list";
		}
		
		break;
		
	case "delete":
		$delete = deleteDesigner($get_designer_id);
		if($delete){
			$msg = "<p>Designer supprimé avec succès.</p>";
		}else{
			$msg = "<p>Une erreur est survenue durant la suppression</p>";
		}
		
		$recup_designer = getDesigner();
		$page_view = "admin_designer_list";
		break;
		
	case "reactive":
		$delete = deleteDesigner($get_designer_id, '1');
		if($delete){
			$msg = "<p>Designer ré-activé avec succès.</p>";
		}else{
			$msg = "<p>Une erreur est survenue durant la réactivation</p>";
		}
		
		$recup_designer = getDesigner();
		$page_view = "admin_designer_list";
		break;
}


?>















