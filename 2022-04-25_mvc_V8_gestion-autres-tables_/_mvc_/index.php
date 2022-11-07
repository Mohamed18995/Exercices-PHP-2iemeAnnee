<?php
session_start();
include_once("base/config.php");
// paramètre qui servira à définir le model à charger
$get_p = isset($_GET["p"]) ? $_GET["p"] : "default";

if(file_exists("model/".$get_p.".php")){
    include_once("model/".$get_p.".php");
}else{
    exit("<b>ERROR</b><br />Le modèle <b>".$get_p."</b> ne peut pas être chargé car il n'existe pas !!!");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
    <head>
        <title></title>
        <meta name="description" content="" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="language" content="fr" />
        <meta name="revisit-after" content="7 days" />
        <meta name="robots" content="index, follow" />
        <link rel="stylesheet" type="text/css" href="css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="css/skeleton.css" />
        <link rel="stylesheet" type="text/css" href="css/skeleton_collapse.css" />
        <link rel="stylesheet" type="text/css" href="css/custom.css" />
        <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js"></script>

    </head>
    <body>
        <?php
		if((isset($_SESSION["admin_id"])) && (!empty($_SESSION["admin_id"])) && (is_numeric($_SESSION["admin_id"]))){
			include_once("include/admin_menu.php");
		}
		
        if(file_exists("view/".$page_view.".php")){
            include_once("view/".$page_view.".php");
        }else{
            echo "<p><b>ERROR</b><br />View non défini</p>";
        }
        ?>
    </body>
</html>
