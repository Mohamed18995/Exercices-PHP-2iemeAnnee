<?php
function getItem(){
	$sql = "SELECT item_id, item_title, item_description, is_visible
			FROM item 
			ORDER BY item_title;
			";
	return requeteResultat($sql);
}

function addItem($value){
	$titre 			= $value["titre"];
	$description 	= $value["description"];
	
	$sql = "INSERT INTO item 
				(item_title, item_description)
			VALUES 
				('$titre', '$description');
			";
	return ExecRequete($sql);
}
?>