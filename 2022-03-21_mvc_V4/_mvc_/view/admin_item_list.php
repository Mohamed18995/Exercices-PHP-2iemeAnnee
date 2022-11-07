<?php
// affichage (ou non) du message d'ajout ou de modification
echo isset($msg) && !empty($msg) ? $msg : "";

// affichage de la liste
if(is_array($result) && sizeof($result) > 0){
	// alors on va pouvoir boucler dessus
	$li = "";
	foreach($result as $r){
		$item_id 			= $r["item_id"];
		$item_title 		= $r["item_title"];
		$item_description 	= $r["item_description"];
		$is_visible 		= $r["is_visible"];
		
		$li .= "<li>";
		$li .= "<a href='index.php?p=admin_item&action=update&id=".$item_id."'>modifier</a> \n";
		$li .= $item_title;
		$li .= "</li>";
	}
	
	echo "<ul>".$li."</ul>";
}else{
	echo "<p>Aucune donnée n'est contenue dans la table item <i>(pour le moment)</i></p>";
}
?>
<p>
	<a href="index.php?p=admin_item&action=add" title="ajouter">ajouter une nouvelle entrée "item"</a>
</p>












