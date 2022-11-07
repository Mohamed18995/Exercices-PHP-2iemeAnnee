<?php
// pour protéger par login et password
verifConnexion();
include_once("lib/manufacturer.php");
$get_action 			= isset($_GET["action"]) 			? $_GET["action"] 			: "list";
$get_manufacturer_id 	= isset($_GET["manufacturer_id"]) 	? $_GET["manufacturer_id"] 	: 0;

$msg = "";


switch($get_action){
	case "list":
		$recup_manufacturer = getManufacturer();
		$page_view = "admin_manufacturer_list";
		
		break;
		
	case "add":
		$post_manufacturer 		= isset($_POST["manufacturer"]) ? filter_input(INPUT_POST, 'manufacturer', FILTER_SANITIZE_SPECIAL_CHARS)   : null;
		$post_description   = isset($_POST["description"])  	? filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS)    : null;
		
		
		// création du formulaire
		$input = [];
		// ajout des différents champs du formulaire
		$input[] = addInput('Nom', ["type" => "text", "value" => $post_manufacturer, "name" => "manufacturer", "class" => "u-full-width"], true, "six columns");
		$input[] = addTextarea('Parcours du manufacturer', ["name" => "description", "class" => "u-full-width"], $post_description, false, "six columns");
		$input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "");
		
		$show_form = form("form_manufacturer", "index.php?p=admin_manufacturer&action=add", "post", $input); 
		
		if($show_form != false){
			$page_view = "admin_manufacturer_form";
		}else{
			
			$data_value = array();
			$data_value["manufacturer"]	= $post_manufacturer;
			$data_value["description"] 	= $post_description;
			
			$add = addManufacturer($data_value);
			if($add){
				$msg = "<p>Manufacturer ajouté avec succès</p>";
			}else{
				$msg = "<p>Erreur lors de l'ajout !</p>";
			}
			
			$recup_manufacturer = getManufacturer();
			$page_view = "admin_manufacturer_list";
			
		}
		
		
		break;
		
	case "update":
		// récupération des données suivant l'id passé en paramètre
		$recup_manufacturer = getManufacturer($get_manufacturer_id);
	
	
		$post_manufacturer 	= isset($_POST["manufacturer"]) ? filter_input(INPUT_POST, 'manufacturer', FILTER_SANITIZE_SPECIAL_CHARS)   : $recup_manufacturer[0]["manufacturer"];
		$post_description   = isset($_POST["description"])  ? filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS)    : $recup_manufacturer[0]["description"];
		
		
		// création du formulaire
		$input = [];
		// ajout des différents champs du formulaire
		$input[] = addInput('Nom', ["type" => "text", "value" => $post_manufacturer, "name" => "manufacturer", "class" => "u-full-width"], true, "six columns");
		$input[] = addTextarea('Parcours du manufacturer', ["name" => "description", "class" => "u-full-width"], $post_description, false, "six columns");
		$input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "");
		
		$show_form = form("form_manufacturer", "index.php?p=admin_manufacturer&action=update&manufacturer_id=".$get_manufacturer_id, "post", $input); 
		
		if($show_form != false){
			$page_view = "admin_manufacturer_form";
		}else{
			$data_value = array();
			$data_value["manufacturer"]	= $post_manufacturer;
			$data_value["description"] 	= $post_description;
			
			$update = updateManufacturer($data_value, $get_manufacturer_id);
			if($update){
				$msg = "<p>Manufacturer mis à jour avec succès</p>";
			}else{
				$msg = "<p>Erreur lors de la mise à jour !</p>";
			}
			
			$recup_manufacturer = getManufacturer();
			$page_view = "admin_manufacturer_list";
		}
		
		break;
		
	case "delete":
		$delete = deleteManufacturer($get_manufacturer_id);
		if($delete){
			$msg = "<p>Manufacturer supprimé avec succès.</p>";
		}else{
			$msg = "<p>Une erreur est survenue durant la suppression</p>";
		}
		
		$recup_manufacturer = getManufacturer();
		$page_view = "admin_manufacturer_list";
		break;
		
	case "reactive":
		$delete = deleteManufacturer($get_manufacturer_id, '1');
		if($delete){
			$msg = "<p>Manufacturer ré-activé avec succès.</p>";
		}else{
			$msg = "<p>Une erreur est survenue durant la réactivation</p>";
		}
		
		$recup_manufacturer = getManufacturer();
		$page_view = "admin_manufacturer_list";
		break;
}


?>















