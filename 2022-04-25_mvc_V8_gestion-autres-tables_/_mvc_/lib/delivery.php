<?php
function getDelivery($id = null){
	if(is_null($id) || !is_numeric($id)){
		$sql = "SELECT delivery_id, delivery, is_visible
				FROM delivery
				ORDER BY delivery;
				";
	}else{
		$sql = "SELECT delivery, is_visible
				FROM delivery
				WHERE delivery_id = $id;
				";
	}
			
	return requeteResultat($sql);
}

function deleteDelivery($id, $is_visible = '0'){
	if(!is_numeric($id) || $id < 1){
		return false;
	}
	$sql = "UPDATE delivery 
				SET is_visible = '$is_visible'
			WHERE delivery_id = $id;
			";
	return ExecRequete($sql);
}

function addDelivery($value){
	$delivery 	= $value["delivery"];
	
	$sql = "INSERT INTO delivery 
				(delivery) 
			VALUES 
				('$delivery');
			";
	return ExecRequete($sql);
}

function updateDelivery($value, $id){
	if(!is_numeric($id)){
		return false;
	}
	$delivery 	= $value["delivery"];
	
	$sql = "UPDATE delivery	
			SET 
				delivery = '$delivery'
			WHERE delivery_id = $id;
			";
	return ExecRequete($sql);
}
?>















