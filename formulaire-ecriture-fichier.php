<?php
$post_nom	         = isset($_POST["nom"]) 	       ? $_POST["nom"] 	        : "";
$post_prenom 	     = isset($_POST["prenom"]) 	       ? $_POST["prenom"] 	    : "";
$post_adresse	     = isset($_POST["adresse"]) 	   ? $_POST["adresse"]      : "";
$post_telephone 	 = isset($_POST["telephone"]) 	   ? $_POST["telephone"]    : "";
$post_mail 	         = isset($_POST["mail"]) 	       ? $_POST["mail"]         : "";
$post_naissance	     = isset($_POST["naissance"])      ? $_POST["naissance"]    : ""; 

// variable qui contiendra les éventuels messages d'erreur
$msg_error = "";

if(empty($post_nom) || empty($post_prenom) || empty($post_telephone) || empty($post_mail)){
	$msg_error .= empty($post_nom) 	        ? "<li>nom est manquant</li>" 	                 : "";
    $msg_error .= empty($post_prenom) 	    ? "<li>prénom est manquant</li>" 	             : "";
    $msg_error .= empty($post_telephone) 	? "<li>numéro de téléphone  est manquant</li>" 	 : "";
    $msg_error .= empty($post_mail) 	    ? "<li>Adresse e-mail est manquant</li>" 	             : "";

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
	<form action="formulaire-ecriture-fichier.php" method="post">
        <p>
			Nom<br /><input type="text" name="nom" value="<?php echo $post_nom; ?>" />
		</p>
		<p>
			Prénom<br /><input type="text" name="prenom" value="<?php echo $post_prenom; ?>" />
		</p>
		<p>
			Adresse Postale<br />
            <input type="text" name="adresse" value="<?php echo $post_adresse; ?>"/>
		</p>
		<p>
			Numéro de téléphone<br />
            <input type="text" name="telephone" value="<?php echo $post_telephone; ?>"/>
		</p>
        <p>
			Adresse e-mail<br />
            <input type="text" name="mail" value="<?php echo $post_mail; ?>"/>
		</p>
        <p>
			Date de naissance<br />
            <input type="text" name="date de naissance" value="<?php echo $post_naissance; ?>"/>
		</p>
        <p>
			<input type="submit" name="submit" value="Envoyer" />
		</p>
	</form>
	<?php
	}else{
		echo "<p>";
        echo "<b>Nom - Prénom </b><br>";
        echo $post_nom." ".$post_prenom."<br><br>";
        echo "<b>Adresse Postale</b><br>";
        echo $post_adresse."<br><br>";
        echo "<b>Numéro de téléphone </b><br>";
        echo $post_telephone."<br><br>";
        echo "<b>E-mail </b><br>";
        echo $post_mail."<br><br>";
        echo "<b>Date de naissance</b><br>";
        echo $post_naissance;
        echo "</p>";
	}
	?>
    <?php
 echo nl2br(file_get_contents('contact.txt'));
 echo '<br><br>';
 echo '<pre>';
 print_r(file('contact.txt'));
 echo '</pre>';
 echo '<br><br>';
 readfile('contact.txt');
 ?>
</body>
</html>