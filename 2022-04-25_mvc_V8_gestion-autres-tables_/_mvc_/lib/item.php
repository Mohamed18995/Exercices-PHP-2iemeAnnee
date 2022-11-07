<?php
function getItem($id=null){
	if(is_null($id) || !is_numeric($id)){
		$sql = "SELECT item_id, item_title, item_description, is_visible
				FROM item 
				ORDER BY item_title;
				";
	}else{
		$sql = "SELECT item_menu, item_title, item_description, is_visible, sortkey
				FROM item 
				WHERE item_id = $id;
				";
	}
	
	return requeteResultat($sql);
}

function addItem($value){
	$titre 			= $value["titre"];
	$description 	= $value["description"];
	$menu 			= $value["menu"];
	
	$sql = "INSERT INTO item 
				(item_title, item_description, item_menu)
			VALUES 
				('$titre', '$description', '$menu');
			";
	return ExecRequete($sql);
}

function updateItem($value, $id){
	$titre 			= $value["titre"];
	$description 	= $value["description"];
	$menu 			= $value["menu"];
	
	$sql = "UPDATE item	
			SET 
				item_title = '$titre',
				item_description = '$description',
				item_menu = '$menu'
			WHERE item_id = $id;
			";
	return ExecRequete($sql);
}

function deleteActiveItem($id){
	if(!is_numeric($id)){
		return false;
	}
	// 1 : vérifier l'état actuel
	$sql = "SELECT is_visible FROM item WHERE item_id = $id;";
	$result = requeteResultat($sql);
	$actuel_is_visible = $result[0]["is_visible"];
	
	if($actuel_is_visible == '1'){
		$is_visible = '0';
	}else{
		$is_visible = '1';
	}
	
	// => $is_visible = $actuel_is_visible == '1' ? '0' : '1';
	// 2 : mise à jour
	$sql = "UPDATE item SET is_visible = '$is_visible' WHERE item_id = $id;";
	return ExecRequete($sql);
}
?>












