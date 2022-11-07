<?php
// pour protéger par login et password
verifConnexion();
include_once("lib/delivery.php");
$get_action 		= isset($_GET["action"]) 		? $_GET["action"] 		: "list";
$get_delivery_id 	= isset($_GET["delivery_id"]) 	? $_GET["delivery_id"] 	: 0;

$msg = "";

switch($get_action){
	case "list":
		$recup_delivery = getDelivery();
		$page_view = "admin_delivery_list";
		
		break;
		
	case "add":
		$post_delivery 		= isset($_POST["delivery"]) ? filter_input(INPUT_POST, 'delivery', FILTER_SANITIZE_SPECIAL_CHARS)   : null;
		
		
		// création du formulaire
		$input = [];
		// ajout des différents champs du formulaire
		$input[] = addInput('Moyen de livraison', ["type" => "text", "value" => $post_delivery, "name" => "delivery", "class" => "u-full-width"], true);
		$input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "");
		
		$show_form = form("form_delivery", "index.php?p=admin_delivery&action=add", "post", $input); 
		
		if($show_form != false){
			$page_view = "admin_delivery_form";
		}else{
			
			$data_value = array();
			$data_value["delivery"]	= $post_delivery;
			
			$add = addDelivery($data_value);
			if($add){
				$msg = "<p>Moyen de livraison ajouté avec succès</p>";
			}else{
				$msg = "<p>Erreur lors de l'ajout !</p>";
			}
			
			$recup_delivery = getDelivery();
			$page_view = "admin_delivery_list";
			
		}
		
		
		break;
		
	case "update":
		// récupération des données suivant l'id passé en paramètre
		$recup_delivery = getDelivery($get_delivery_id);
	
	
		$post_delivery 	= isset($_POST["delivery"]) ? filter_input(INPUT_POST, 'delivery', FILTER_SANITIZE_SPECIAL_CHARS)   : $recup_delivery[0]["delivery"];
		
		
		// création du formulaire
		$input = [];
		// ajout des différents champs du formulaire
		$input[] = addInput('Moyen de livraison', ["type" => "text", "value" => $post_delivery, "name" => "delivery", "class" => "u-full-width"], true);
		$input[] = addSubmit(["value" => "envoyer", "name" => "submit"], "");
		
		$show_form = form("form_delivery", "index.php?p=admin_delivery&action=update&delivery_id=".$get_delivery_id, "post", $input); 
		
		if($show_form != false){
			$page_view = "admin_delivery_form";
		}else{
			$data_value = array();
			$data_value["delivery"]	= $post_delivery;
			
			$update = updateDelivery($data_value, $get_delivery_id);
			if($update){
				$msg = "<p>Moyen de livraison mis à jour avec succès</p>";
			}else{
				$msg = "<p>Erreur lors de la mise à jour !</p>";
			}
			
			$recup_delivery = getDelivery();
			$page_view = "admin_delivery_list";
		}
		
		break;
		
	case "delete":
		$delete = deleteDelivery($get_delivery_id);
		if($delete){
			$msg = "<p>Moyen de livraison supprimé avec succès.</p>";
		}else{
			$msg = "<p>Une erreur est survenue durant la suppression</p>";
		}
		
		$recup_delivery = getDelivery();
		$page_view = "admin_delivery_list";
		break;
		
	case "reactive":
		$delete = deleteDelivery($get_delivery_id, '1');
		if($delete){
			$msg = "<p>Moyen de livraison ré-activé avec succès.</p>";
		}else{
			$msg = "<p>Une erreur est survenue durant la réactivation</p>";
		}
		
		$recup_delivery = getDelivery();
		$page_view = "admin_delivery_list";
		break;
}


?>















