<?php
$post_civilite   	= isset($_POST["civilite"])	   ? $_POST["civilite"]  : "";
$post_nom	        = isset($_POST["nom"]) 	       ? $_POST["nom"] 	     : "";
$post_prenom 	    = isset($_POST["prenom"]) 	   ? $_POST["prenom"] 	 : "";
$post_rue 	        = isset($_POST["rue"]) 	       ? $_POST["rue"]       : "";
$post_num 	        = isset($_POST["num"]) 	       ? $_POST["num"]       : "";
$post_cp 	        = isset($_POST["cp"]) 	       ? $_POST["cp"]        : "";
$post_localite 	    = isset($_POST["localite"])    ? $_POST["localite"]  : "";
$post_pays 	        = isset($_POST["pays"]) 	   ? $_POST["pays"]      : "";
$post_permis 	    = isset($_POST["permis"]) 	   ? $_POST["permis"]    : "";
$post_hobby 	    = isset($_POST["hobby"]) 	   ? $_POST["hobby"]     : array("php", "html");
// variable qui contiendra les éventuels messages d'erreur
$msg_error = "";

//Creation du tableau qui contiedra les civilité

$array_civilite  = [];
$array_civilite["M"]  = "Monsieur";
$array_civilite["Mme"]  = "Madame";
$array_civilite["Melle"]  = "Mademoiselle";

//Creation du tableau qui contiedra les pays

$array_pays  = [];
$array_pays["BE"]  = "Belgique";
$array_pays["FR"]  = "France";
$array_pays["NL"]  = "Pays-Bas";
$array_pays["LU"]  = "Luxembourg";
$array_pays["UK"]  = "Grande-Bretagne";
$array_pays["ES"]  = "Espagne";
$array_pays["IT"]  = "Italie";
$array_pays["DE"]  = "Allemagne";
$array_pays["AT"]  = "Autriche";
$array_pays["DK"]  = "Danemark";

//Tri du tableaupar ordre alphabétique
asort($array_pays);

//Creation du tableau qui contiedra les centres d'intérét

$array_hobby  = [];
$array_hobby["html"]  = "Le HTML";
$array_hobby["css"]  = "Le CSS";
$array_hobby["php"]  = "Le PHP";
$array_hobby["js"]  = "Le JS";

if(empty($post_civilite) || empty($post_nom) || empty($post_prenom) || empty($post_rue) || empty($post_num) || empty($post_cp) || empty($post_localite) || empty($post_pays) || empty($post_permis) || empty($post_hobby)){
	$msg_error .= empty($post_civilite) 	? "<li>civilité  est manquant</li>" 		: "";
	$msg_error .= empty($post_nom) 	        ? "<li>nom est manquant</li>" 	            : "";
    $msg_error .= empty($post_prenom) 	    ? "<li>prénom est manquant</li>" 	        : "";
	$msg_error .= empty($post_rue) 	        ? "<li>rue est manquant</li>" 	            : "";
    $msg_error .= empty($post_num) 	        ? "<li>num est manquant</li>" 	            : "";
	$msg_error .= empty($post_cp) 	        ? "<li>code postale est manquant</li>"      : "";
    $msg_error .= empty($post_localite)     ? "<li>localité est manquant</li>" 	        : "";
    $msg_error .= empty($post_pays) 	    ? "<li>pays est manquant</li>" 	            : "";
    $msg_error .= empty($post_prrmis) 	    ? "<li>permis est manquant</li>" 	        : "";
    $msg_error .= empty($post_hobby) 	    ? "<li>hobby est manquant</li>" 	        : "";

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
	<form action="exercice-form-creationFormulaie-lesArray.php" method="post">
        <p>
			Civilite<br/>
            <select name ="civilite">
                <?php
                $option_civilite = "\n";
                foreach($array_civilite as $civilite_cle => $civilite_valeur){
                    $selected = ($civilite_cle == $post_civilite) ? " selected='selected'" : "";
                    $option_civilite .= "\t\t\t\t<option value='".$civilite_cle."'".$selected.">".$civilite_valeur."</option>\n";
                }
                echo $option_civilite;
                ?>
            </select>
		</p>
        <p>
			Nom<br /><input type="text" name="nom" value="<?php echo $post_nom; ?>" />
		</p>
		<p>
			Prénom<br /><input type="text" name="prenom" value="<?php echo $post_prenom; ?>" />
		</p>
		<p>
			Adresse Postale<br />
            <input type="text" name="rue" value="<?php echo $post_rue; ?>" placeholder="rue"/> <input type="text" name="num" value="<?php echo $post_num; ?>" placeholder="num" />
            <input type="text" name="cp" value="<?php echo $post_cp; ?>" placeholder="code postale" /> <input type="text" name="localite" value="<?php echo $post_localite; ?>" placeholder="localite" />
		</p>
		<p>
			pays<br />
			<select name ="pays"><br />
            <?php
            $option_pays = "\n";
            foreach($array_pays as $pays_cle => $pays_valeur){
                $selected =($pays_cle == $post_pays) ? "selected='selected'" : "";
                $option_pays .= "\t\t\t\t<option value ='".$pays_cle."'".$selected.">".$pays_valeur."</option>\n"; 
            }
            echo $option_pays;
            ?>
            </select>   
		</p>
		<p>
			Permis de conduire<br />
            <input type="radio" name="permis" value="oui"<?php echo $post_permis == "oui" ? " checked='checked'" : ""; ?> /> Oui<br>
            <input type="radio" name="permis" value="non"<?php echo $post_permis == "non" ? " checked='checked'" : ""; ?> /> Non
		</p>
		<p>
            Centre d'intérét<br/>
            <?php
            $liste_hobby = "\n";
            foreach($array_hobby as $hobby_cle => $hobby_valeur){
                $checked =in_array($hobby_cle, $post_hobby) ? " checked='checked'" : "";
                $liste_hobby .= "\t\t\t\t<input type ='checkbox' name='hobby[]' value='".$hobby_cle."'".$checked.">".$hobby_valeur."<br>\n"; 
            }
            echo $liste_hobby;
            ?>
		</p>
        <p>
			<input type="submit" name="submit" value="Envoyer" />
		</p>
	</form>
	<?php
	}else{
		echo "<p>";
        echo "<b>Civilité - Nom - Prénom</b><br>";
        echo $array_civilite[$post_civilite]." ".$post_nom." ".$post_prenom."<br><br>";
        echo "<b>Adresse Postale</b><br>";
        echo $post_rue." ".$post_num.", ".$post_cp." ".$post_localite."<br>".$array_pays[$post_pays]."<br><br>";
		echo "<b>Permis de conduire :</b><br>".$post_permis."<br><br>";
        $aff_hobby = "";
        foreach($post_hobby as $hobby){
            $aff_hobby .= "- ".$hobby."<br>";
        }
        echo "<b>Centre d'intérét :</b><br>".$aff_hobby."<br>";
        echo "</p>";
	}
	?>
</body>
</html>