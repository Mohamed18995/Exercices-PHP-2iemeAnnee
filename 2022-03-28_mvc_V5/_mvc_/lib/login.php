<?php
function verifLogin($login, $password){
	$sql = "SELECT admin_id, pseudo 
			FROM admin 
			WHERE login LIKE '$login' AND password LIKE MD5('$password');";
	return requeteResultat($sql);
}
?>