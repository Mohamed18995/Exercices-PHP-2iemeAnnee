<?php
$nom    	= isset($_POST["nom"]) 		? $_POST["nom"] 	: "";
$prenom 	= isset($_POST["prenom"]) 	? $_POST["prenom"] 	: "";
$message  	= isset($_POST["message"]) 	? $_POST["message"] : "";

$msg_error = "";
$show_form = true;
if(empty($nom) || empty($prenom) || empty($message)){
	
	$msg_error .= empty($nom) 		? "<li>nom est manquant</li>" 		: "";
	$msg_error .= empty($prenom) 	? "<li>prénom est manquant</li>" 	: "";
	$msg_error .= empty($message) 	? "<li>message est manquant</li>" 	: "";

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
			Message<br /><textarea name="message"><?php echo $message; ?></textarea>
		</p>
		<p>
			<input type="submit" name="submit" value="Envoyer" />
		</p>
	</form>
	<?php
	}else{
		echo "nom : ".$nom;
		echo "prenom : ".$prenom;
		echo "message : ".$message;
	}
	?>
</body>
</html>