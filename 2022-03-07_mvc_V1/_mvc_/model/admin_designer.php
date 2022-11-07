<?php
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
		
		$data_value = array();
		$data_value["firstname"] 	= "TEST";
		$data_value["lastname"] 	= "test-07-03-22";
		$data_value["description"] 	= "taratata";
		
		$add = addDesigner($data_value);
		if($add){
			$msg = "<p>Designer ajouté avec succès</p>";
		}else{
			$msg = "<p>Erreur lors de l'ajout !</p>";
		}
		
		$recup_designer = getDesigner();
		$page_view = "admin_designer_list";
		
		break;
		
	case "update":
		
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















