<?php
// vérifier si la session est active sinon retour au login
if((!isset($_SESSION["admin_id"])) || (empty($_SESSION["admin_id"]))|| (!is_numeric($_SESSION["admin_id"]))){
	header("Location: index.php?p=login");
	exit;
}
$page_view = "admin_home";
?>