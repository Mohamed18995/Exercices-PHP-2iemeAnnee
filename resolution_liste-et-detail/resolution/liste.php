<?php
include_once("include/contact.php");
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
    $li = "";
    foreach($contact as $key => $value){
        $nom    = $value["nom"];
        $prenom = $value["prenom"];

        $lien_voir = "<a href='detail_personne.php?indice=".$key."'>voir</a>";

        $li .= "<li>".$lien_voir." - ".$nom." ".$prenom."</li>";
    }

    echo "<ul>".$li."</ul>";
    ?>

</body>
</html>