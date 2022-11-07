<?php
// pour protéger par login et password
verifConnexion();
include_once("lib/shape.php");
$get_action 	= isset($_GET["action"]) 	? $_GET["action"] 		: "list";
$get_shape_id 	= isset($_GET["shape_id"]) 	? $_GET["shape_id"] 	: 0;

$msg = "";


switch($get_action){
	case "list":
		$recup_shape = getShape();
		$page_view = "admin_shape_list";
		
		break;
		
	case "add":
		$post_shape 		= isset($_POST["shape"]) 		? filter_input(INPUT_POST, 'shape', FILTER_SANITIZE_SPECIAL_CHARS)   		: null;
		$post_description   = isset($_POST["description"])  ? filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS)	: null;
		
		
		// création du formulaire
		$input = [];
		// ajout des différents champs du formulaire
		$input[] = addInput('Nom', ["type" => "text", "value" => $post_shape, "name" => "shape", "class" => "u-full-width"], true, "six columns");
		$input[] = addTextarea('Description', ["name" => "description", "class" => "u-full-width"], $post_description, false, "six columns");
		$input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "");
		
		$show_form = form("form_shape", "index.php?p=admin_shape&action=add", "post", $input); 
		
		if($show_form != false){
			$page_view = "admin_shape_form";
		}else{
			
			$data_value = array();
			$data_value["shape"]	= $post_shape;
			$data_value["description"] 	= $post_description;
			
			$add = addShape($data_value);
			if($add){
				$msg = "<p>Shape ajouté avec succès</p>";
			}else{
				$msg = "<p>Erreur lors de l'ajout !</p>";
			}
			
			$recup_shape = getShape();
			$page_view = "admin_shape_list";
			
		}
		
		
		break;
		
	case "update":
		// récupération des données suivant l'id passé en paramètre
		$recup_shape = getShape($get_shape_id);
	
	
		$post_shape 		= isset($_POST["shape"]) 		? filter_input(INPUT_POST, 'shape', FILTER_SANITIZE_SPECIAL_CHARS)   		: $recup_shape[0]["shape_title"];
		$post_description   = isset($_POST["description"])  ? filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS)    : $recup_shape[0]["description"];
		
		
		// création du formulaire
		$input = [];
		// ajout des différents champs du formulaire
		$input[] = addInput('Nom', ["type" => "text", "value" => $post_shape, "name" => "shape", "class" => "u-full-width"], true, "six columns");
		$input[] = addTextarea('Parcours du shape', ["name" => "description", "class" => "u-full-width"], $post_description, false, "six columns");
		$input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "");
		
		$show_form = form("form_shape", "index.php?p=admin_shape&action=update&shape_id=".$get_shape_id, "post", $input); 
		
		if($show_form != false){
			$page_view = "admin_shape_form";
		}else{
			$data_value = array();
			$data_value["shape"]	= $post_shape;
			$data_value["description"] 	= $post_description;
			
			$update = updateShape($data_value, $get_shape_id);
			if($update){
				$msg = "<p>Shape mis à jour avec succès</p>";
			}else{
				$msg = "<p>Erreur lors de la mise à jour !</p>";
			}
			
			$recup_shape = getShape();
			$page_view = "admin_shape_list";
		}
		
		break;
		
	case "delete":
		$delete = deleteShape($get_shape_id);
		if($delete){
			$msg = "<p>Shape supprimé avec succès.</p>";
		}else{
			$msg = "<p>Une erreur est survenue durant la suppression</p>";
		}
		
		$recup_shape = getShape();
		$page_view = "admin_shape_list";
		break;
		
	case "reactive":
		$delete = deleteShape($get_shape_id, '1');
		if($delete){
			$msg = "<p>Shape ré-activé avec succès.</p>";
		}else{
			$msg = "<p>Une erreur est survenue durant la réactivation</p>";
		}
		
		$recup_shape = getShape();
		$page_view = "admin_shape_list";
		break;
}


?>















