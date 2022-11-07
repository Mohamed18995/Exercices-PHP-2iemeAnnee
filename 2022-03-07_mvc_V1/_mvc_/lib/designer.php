<?php
function getDesigner(){
	$sql = "SELECT designer_id, firstname, lastname, description, is_visible
			FROM designer
			ORDER BY lastname, firstname;
			";
			
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
?>















