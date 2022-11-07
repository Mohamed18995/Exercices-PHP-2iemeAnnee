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
?>












