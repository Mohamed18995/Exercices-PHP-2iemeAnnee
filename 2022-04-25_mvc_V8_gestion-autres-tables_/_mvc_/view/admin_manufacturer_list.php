<p><a href="index.php?p=admin_manufacturer&action=add" title="ajouter">Ajouter une nouvelle manufacture</a></p>
<?php
echo $msg;

if(is_array($recup_manufacturer) && sizeof($recup_manufacturer) > 0){
	$li = "";
	foreach($recup_manufacturer as $rd){
		$manufacturer_id 	= $rd["manufacturer_id"];
		$manufacturer 		= $rd["manufacturer"];
		$description 		= $rd["description"];
		$is_visible 		= $rd["is_visible"];
		
		if($is_visible == "1"){
			$li .= "<li>";
			$li .= " <a href='index.php?p=admin_manufacturer&action=update&manufacturer_id=".$manufacturer_id."' title='éditer'>edit</a> ";
			$li .= " <a href='index.php?p=admin_manufacturer&action=delete&manufacturer_id=".$manufacturer_id."' title='supprimer'>delete</a> ";
			$li .= $manufacturer;
			$li .= "</li>";
		}else{
			$li .= "<li>";
			$li .= " <a href='index.php?p=admin_manufacturer&action=update&manufacturer_id=".$manufacturer_id."' title='éditer'>edit</a> ";
			$li .= " <a href='index.php?p=admin_manufacturer&action=reactive&manufacturer_id=".$manufacturer_id."' title='rendre à nouveau visible'>réactiver</a> ";
			$li .= "<s>".$manufacturer."</s>";
			$li .= "</li>";
		}
		
	}
	echo "<ul>".$li."</ul>";
}else{
	echo "<p>Aucun manufacturer pour le moment</p>";
}

?>