<p><a href="index.php?p=admin_designer&action=add" title="ajouter">Ajouter un nouveau designer</a></p>
<?php
echo $msg;

if(is_array($recup_designer) && sizeof($recup_designer) > 0){
	$li = "";
	foreach($recup_designer as $rd){
		$designer_id 	= $rd["designer_id"];
		$firstname 		= $rd["firstname"];
		$lastname 		= $rd["lastname"];
		$description 	= $rd["description"];
		$is_visible 	= $rd["is_visible"];
		
		if($is_visible == "1"){
			$li .= "<li>";
			$li .= " <a href='index.php?p=admin_designer&action=update&designer_id=".$designer_id."' title='éditer'>edit</a> ";
			$li .= " <a href='index.php?p=admin_designer&action=delete&designer_id=".$designer_id."' title='supprimer'>delete</a> ";
			$li .= $lastname." ".$firstname;
			$li .= "</li>";
		}else{
			$li .= "<li>";
			$li .= " <a href='index.php?p=admin_designer&action=update&designer_id=".$designer_id."' title='éditer'>edit</a> ";
			$li .= " <a href='index.php?p=admin_designer&action=reactive&designer_id=".$designer_id."' title='rendre à nouveau visible'>réactiver</a> ";
			$li .= "<s>".$lastname." ".$firstname."</s>";
			$li .= "</li>";
		}
		
	}
	echo "<ul>".$li."</ul>";
}else{
	echo "<p>Aucun designer pour le moment</p>";
}

?>