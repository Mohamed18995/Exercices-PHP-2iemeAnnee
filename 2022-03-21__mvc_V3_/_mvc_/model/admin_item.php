<?php
include_once("lib/item.php");

$get_action = isset($_GET["action"]) ? $_GET["action"] : "list";

switch($get_action){
	case "list":
		$result = getItem();
		$page_view = "admin_item_list";
		break;
		
	case "add":
		$post_titre     	= isset($_POST["titre"])    	? filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS)      	: null;
		$post_description   = isset($_POST["description"])  ? filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS)	: null;
		
		// création du formulaire
		$input = [];
		// ajout des différents champs du formulaire
		$input[] = addInput("Titre", ["type"=>"text", "name"=>"titre", "value"=>$post_titre], true);
		$input[] = addTextarea("Description", ["name"=>"description"], $post_description, true);
		$input[] = addSubmit(["name"=>"submit", "value"=>"ajouter"], "");
		
		$show_form = form("mon_form", "index.php?p=admin_item&action=add", "post", $input);
		
		if($show_form != false){
			$page_view = "admin_item_form";
		}else{
			// on insère les données
			$data 					= [];
			$data["titre"] 			= $post_titre;
			$data["description"] 	= $post_description;
			
			$ajout = addItem($data);
			
			if($ajout){
				$msg = "<p>Item ajouté avec succès</p>"; 
			}else{
				$msg = "<p>Erreur lors de l'ajout d'un nouvel item</p>";
			}
			
			$result = getItem();
			$page_view = "admin_item_list";
		}
		
		
		
		break;
		
	case "update":
		
		break;
		
	case "delete":
		
		break;
		
	case "reactive":
		
		break;
}
?>