<?php
// pour protéger par login et password
verifConnexion();
// réinitialiser la SESSION à un tableau vide
$_SESSION = [];
// détruire la session
session_destroy();
// rediriger vers le model "admin" qui va rediriger vers login
header("Location: index.php?p=admin");
?>