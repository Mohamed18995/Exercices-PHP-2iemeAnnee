<?php
include_once("include/contact.php");

$indice = $_GET["indice"];

$recup_info = $contact[$indice];
?>
<!DOCTYPE html>

<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<ul>
    <li>Nom : <?php echo $recup_info["nom"]; ?></li>
    <li>Prénom : <?php echo $recup_info["prenom"]; ?></li>
    <li>Adresse : <?php echo $recup_info["adresse"]; ?></li>
    <li>Tél. : <?php echo $recup_info["tel"]; ?></li>
    <li>E-mail : <?php echo $recup_info["email"]; ?></li>
    <li>Date de naissance : <?php echo $recup_info["naissance"]; ?></li>
</ul>
<p><a href="liste.php">retour à la liste</a></p>

</body>
</html>
