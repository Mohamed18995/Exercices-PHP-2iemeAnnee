<p><a href="index.php?p=admin_shape&action=add" title="ajouter">Ajouter un nouvel état de surface</a></p>
<?php
echo $msg;

if(is_array($recup_shape) && sizeof($recup_shape) > 0){
	$li = "";
	foreach($recup_shape as $rd){
		$shape_id 		= $rd["shape_id"];
		$shape 			= $rd["shape_title"];
		$description 	= $rd["description"];
		$is_visible 	= $rd["is_visible"];
		
		if($is_visible == "1"){
			$li .= "<li>";
			$li .= " <a href='index.php?p=admin_shape&action=update&shape_id=".$shape_id."' title='éditer'>edit</a> ";
			$li .= " <a href='index.php?p=admin_shape&action=delete&shape_id=".$shape_id."' title='supprimer'>delete</a> ";
			$li .= $shape;
			$li .= "</li>";
		}else{
			$li .= "<li>";
			$li .= " <a href='index.php?p=admin_shape&action=update&shape_id=".$shape_id."' title='éditer'>edit</a> ";
			$li .= " <a href='index.php?p=admin_shape&action=reactive&shape_id=".$shape_id."' title='rendre à nouveau visible'>réactiver</a> ";
			$li .= "<s>".$shape."</s>";
			$li .= "</li>";
		}
		
	}
	echo "<ul>".$li."</ul>";
}else{
	echo "<p>Aucun shape pour le moment</p>";
}

?>