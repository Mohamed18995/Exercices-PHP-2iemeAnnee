<p><a href="index.php?p=admin_delivery&action=add" title="ajouter">Ajouter un nouveau moyen de livraison</a></p>
<?php
echo $msg;

if(is_array($recup_delivery) && sizeof($recup_delivery) > 0){
	$li = "";
	foreach($recup_delivery as $rd){
		$delivery_id 	= $rd["delivery_id"];
		$delivery 		= $rd["delivery"];
		$is_visible 	= $rd["is_visible"];
		
		if($is_visible == "1"){
			$li .= "<li>";
			$li .= " <a href='index.php?p=admin_delivery&action=update&delivery_id=".$delivery_id."' title='éditer'>edit</a> ";
			$li .= " <a href='index.php?p=admin_delivery&action=delete&delivery_id=".$delivery_id."' title='supprimer'>delete</a> ";
			$li .= $delivery;
			$li .= "</li>";
		}else{
			$li .= "<li>";
			$li .= " <a href='index.php?p=admin_delivery&action=update&delivery_id=".$delivery_id."' title='éditer'>edit</a> ";
			$li .= " <a href='index.php?p=admin_delivery&action=reactive&delivery_id=".$delivery_id."' title='rendre à nouveau visible'>réactiver</a> ";
			$li .= "<s>".$delivery."</s>";
			$li .= "</li>";
		}
		
	}
	echo "<ul>".$li."</ul>";
}else{
	echo "<p>Aucun delivery pour le moment</p>";
}

?>