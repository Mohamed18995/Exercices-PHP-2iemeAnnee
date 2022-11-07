<?php
function getShape($id = null){
	if(is_null($id) || !is_numeric($id)){
		$sql = "SELECT shape_id, shape_title, description, is_visible
				FROM shape
				ORDER BY shape_title;
				";
	}else{
		$sql = "SELECT shape_title, description, is_visible
				FROM shape
				WHERE shape_id = $id;
				";
	}
			
	return requeteResultat($sql);
}

function deleteShape($id, $is_visible = '0'){
	if(!is_numeric($id) || $id < 1){
		return false;
	}
	$sql = "UPDATE shape 
				SET is_visible = '$is_visible'
			WHERE shape_id = $id;
			";
	return ExecRequete($sql);
}

function addShape($value){
	$shape 			= $value["shape"];
	$description 	= $value["description"];
	
	$sql = "INSERT INTO shape 
				(shape_title, description) 
			VALUES 
				('$shape', '$description');
			";
	return ExecRequete($sql);
}

function updateShape($value, $id){
	if(!is_numeric($id)){
		return false;
	}
	$shape 			= $value["shape"];
	$description 	= $value["description"];
	
	$sql = "UPDATE shape	
			SET 
				shape_title = '$shape',
				description = '$description'
			WHERE shape_id = $id;
			";
	return ExecRequete($sql);
}
?>















