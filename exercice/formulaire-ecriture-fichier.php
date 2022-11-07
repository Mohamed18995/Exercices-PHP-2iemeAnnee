<?php
// initialisation des variables au cas où on accederait au script sans passer par le formulaire
$nom        = isset($_POST["nom"])      ? $_POST["nom"]     : "";
$prenom     = isset($_POST["prenom"])   ? $_POST["prenom"]  : "";
$postale    = isset($_POST["postale"])  ? $_POST["postale"] : "";
$tel        = isset($_POST["tel"])      ? $_POST["tel"]     : "";
$email      = isset($_POST["email"])    ? $_POST["email"]   : "";
$naissance  = isset($_POST["naissance"])  ? $_POST["naissance"] : "";


if(empty($_POST)){
    $etape = "form";
}else{
    if(empty($nom) || empty($prenom) || empty($email) || empty($tel)){
        $error_msg .= empty($nom)       ? "<li>nom</li>"                : "";
        $error_msg .= empty($prenom)    ? "<li>prenom</li>"             : "";
        $error_msg .= empty($email)     ? "<li>e-mail</li>"             : "";
        $error_msg .= empty($tel)       ? "<li>n° de téléphone</li>"    : "";

        $etape = "form";
    }else{
		$txt = fopen ("01_contact.txt", "a");
		$user = "Nom :"." ".$nom." "."prénom :"." ".$prenom." "."postale :"." ".$postale." "."Téléphone :"." ".$tel." "."Email :"." ".$email." "."Naissance :".$naissance;
		fwrite($txt, $user);
        // stockage du nom de fichier dans une variable
        $file_name = '01_contact.php';
        // ouverture du fichier en lecture et écriture
        // si le fichier n'existe pas, il sera créé
        // le curseur est placé en début de fichier
        $res = fopen($file_name, 'c+b');
        // récupération du contenu du fichier
        $content = file_get_contents($file_name);
        // calcul de la longueur de la chaîne de caractère
        $taille = strlen($content);
        // chaîne à insérer
        $start = $taille == 0 ? "<?php\n\$contact = array();\n" : "";
        // calcul de la position du curseur
        $position = $taille == 0 ? 0 : $taille-3;
        // positionnement du curseur
        fseek($res, $position);
        // création de la chaîne à ajouter
        $new = "\n\$contact[] = array(\"nom\" => \"".$nom."\", \"prenom\" => \"".$prenom."\", \"adresse\" => \"".$postale."\", \"tel\" => \"".$tel."\", \"email\" => \"".$email."\", \"naissance\" => \"".$naissance."\");\n";
        $new .= "?>";
        // écriture dans le fichier
        fputs($res, $start.$new);
        fclose($res);

        $etape = "succes";
    }
}

?>
<!DOCTYPE html>

<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .missingfield{
                border: 1px solid red;
            }
        </style>
    </head>
    <body>
    <?php

    switch($etape){
        case "form":
            if(!empty($error_msg)){
                echo "<p>Les informations suivantes sont manquantes :</p>";
                echo "<ul>".$error_msg."</ul>";
                echo "<p>Veuillez corriger !</p>";
            }
            ?>
            <form action="formulaire-ecriture-fichier.php" method="post">
                <p>
                    Nom *<br /><input type="text" name="nom" value="<?php echo $nom; ?>" />
                </p>
                <p>
                    Prénom *<br /><input type="text" name="prenom" value="<?php echo $prenom; ?>" />
                </p>
                <p>
                    Adresse postale<br /><input type="text" name="postale" value="<?php echo $postale; ?>" />
                </p>
                <p>
                    N° de téléphone *<br /><input type="text" name="tel" value="<?php echo $tel; ?>" />
                </p>
                <p>
                    E-mail *<br /><input type="text" name="email" value="<?php echo $email; ?>" />
                </p>
                <p>
                    Date de naissance<br /><input type="text" name="naissance" value="<?php echo $naissance; ?>" />
                </p>
                <p>
                    <input type="submit" name="submit" value="Envoyer" />
                </p>
            </form>
            <?php
            break;

        case "succes":
            echo "<p>Fichier mis à jour avec succès !</p>";
            break;
    }

    ?>

    </body>
</html>