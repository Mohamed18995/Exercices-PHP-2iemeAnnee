<?php
function getManufacturer($id = null){
	if(is_null($id) || !is_numeric($id)){
		$sql = "SELECT manufacturer_id, manufacturer, description, is_visible
				FROM manufacturer
				ORDER BY manufacturer;
				";
	}else{
		$sql = "SELECT manufacturer, description, is_visible
				FROM manufacturer
				WHERE manufacturer_id = $id;
				";
	}
			
	return requeteResultat($sql);
}

function deleteManufacturer($id, $is_visible = '0'){
	if(!is_numeric($id) || $id < 1){
		return false;
	}
	$sql = "UPDATE manufacturer 
				SET is_visible = '$is_visible'
			WHERE manufacturer_id = $id;
			";
	return ExecRequete($sql);
}

function addManufacturer($value){
	$manufacturer 	= $value["manufacturer"];
	$description 	= $value["description"];
	
	$sql = "INSERT INTO manufacturer 
				(manufacturer, description) 
			VALUES 
				('$manufacturer', '$description');
			";
	return ExecRequete($sql);
}

function updateManufacturer($value, $id){
	if(!is_numeric($id)){
		return false;
	}
	$manufacturer 	= $value["manufacturer"];
	$description 	= $value["description"];
	
	$sql = "UPDATE manufacturer	
			SET 
				manufacturer = '$manufacturer',
				description = '$description'
			WHERE manufacturer_id = $id;
			";
	return ExecRequete($sql);
}
?>















