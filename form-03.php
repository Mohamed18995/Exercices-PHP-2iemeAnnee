<?php
$nom    	= isset($_POST["nom"]) 		? $_POST["nom"] 	: "";
$prenom 	= isset($_POST["prenom"]) 	? $_POST["prenom"] 	: "";
$adresse  	= isset($_POST["adresse"]) 	? $_POST["adresse"] : "";
$pays  	= isset($_POST["pays"]) 	    ? $_POST["pays"]    : "";

$msg_error = "";
$show_form = true;
if(empty($nom) || empty($prenom) || empty($message)){
	
	$msg_error .= empty($nom) 		? "<li>nom est manquant</li>" 		: "";
	$msg_error .= empty($prenom) 	? "<li>prénom est manquant</li>" 	: "";
	$msg_error .= empty($adresse) 	? "<li>adresse est manquant</li>" 	: "";
	$msg_error .= empty($pays) 	? "<li>pays est manquant</li>" 	: "";

    $show_form = true;
}else{
	$show_form = false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<?php
	if(!empty($_POST)){
		echo $msg_error;		
	}
	if($show_form){
	?>
	<form action="form-02.php" method="post">
		<p>
			Nom<br /><input type="text" name="nom" value="<?php echo $nom; ?>" />
		</p>
		<p>
			Prénom<br /><input type="text" name="prenom" value="<?php echo $prenom; ?>" />
		</p>
		<p>
			adresse<br /><textarea name="adresse"><?php echo $adresse; ?></textarea>
		</p>
		<p>
			pays<br />
			<select name ="pays"><br />
			   <option value = "BE"><?php echo ($pays == "BE") ? " selected='selected'" : ""; ?>Belgique</option>
			   <option value = "FR"><?php echo ($pays == "FR") ? " selected='selected'" : ""; ?>France</option>
			   <option value = "NL"><?php echo ($pays == "NL") ? " selected='selected'" : ""; ?>Pays-Bas</option>
		</p>
		<p>
			Message<br /><textarea name="message"><?php echo $message; ?></textarea>
		</p>
		<p>
			<input type="submit" name="submit" value="Envoyer" />
		</p>
	</form>
	<?php
	}else{
		echo "<p>";
		echo "nom : ".$nom;
		echo "prenom : ".$prenom;
		echo "adresse : ".$message;
		echo "</p>";
		
	}
	?>
</body>
</html>