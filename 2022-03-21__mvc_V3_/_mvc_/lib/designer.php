<?php
function getDesigner($id = null){
	if(is_null($id) || !is_numeric($id)){
		$sql = "SELECT designer_id, firstname, lastname, description, is_visible
				FROM designer
				ORDER BY lastname, firstname;
				";
	}else{
		$sql = "SELECT firstname, lastname, description, is_visible
				FROM designer
				WHERE designer_id = $id;
				";
	}
			
	return requeteResultat($sql);
}

function deleteDesigner($id, $is_visible = '0'){
	if(!is_numeric($id) || $id < 1){
		return false;
	}
	$sql = "UPDATE designer 
				SET is_visible = '$is_visible'
			WHERE designer_id = $id;
			";
	return ExecRequete($sql);
}

function addDesigner($value){
	$firstname 		= $value["firstname"];
	$lastname 		= $value["lastname"];
	$description 	= $value["description"];
	
	$sql = "INSERT INTO designer 
				(firstname, lastname, description) 
			VALUES 
				('$firstname', '$lastname', '$description');
			";
	return ExecRequete($sql);
}

function updateDesigner($value, $id){
	if(!is_numeric($id)){
		return false;
	}
	$firstname 		= $value["firstname"];
	$lastname 		= $value["lastname"];
	$description 	= $value["description"];
	
	$sql = "UPDATE designer	
			SET 
				firstname = '$firstname',
				lastname = '$lastname',
				description = '$description'
			WHERE designer_id = $id;
			";
	return ExecRequete($sql);
}
?>















