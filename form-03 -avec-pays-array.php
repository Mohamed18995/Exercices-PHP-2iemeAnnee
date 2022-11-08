<?php
$nom    	= isset($_POST["nom"]) 		? $_POST["nom"] 	: "";
$prenom 	= isset($_POST["prenom"]) 	? $_POST["prenom"] 	: "";
$message  	= isset($_POST["message"]) 	? $_POST["message"] : "";
$pays  		= isset($_POST["pays"]) 	? $_POST["pays"] 	: "";

$msg_error = "";
// création du tableau qui contiendra les pays
$array_pays = [];
$array_pays["BE"] = "Belgique";
$array_pays["FR"] = "France";
$array_pays["NL"] = "Pays-Bas";
$array_pays["LU"] = "Luxembourg";
$array_pays["UK"] = "Grande-Bretagne";
$array_pays["ES"] = "Espagne";
$array_pays["IT"] = "Italie";
$array_pays["DE"] = "Allemagne";
$array_pays["AT"] = "Autriche";
$array_pays["DK"] = "Danemark";

// tri du tableau par ordre alphabétique
asort($array_pays);
