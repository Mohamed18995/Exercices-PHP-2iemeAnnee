<?php
include_once("base/config.php");

// récupération de l'information limit passée dans l'url
$get_limit = isset($_GET["limit"]) ? $_GET["limit"] : 1;

// recuperer le nombre de résultat dans la table
$sql_nbre       = "SELECT COUNT(*) as nbre FROM designer;";
$result_nbre    = requeteResultat($sql_nbre);
// récupération de l'information dans le tableau ci-dessus
$nombre_total   = $result_nbre[0]["nbre"];

// nombre de résultat par page
$nombre_par_page = 10;

// nombre de page de résultat
$nombre_de_page = ceil($nombre_total/$nombre_par_page);

for($i = 1; $i <= $nombre_de_page; $i++){
    echo " <a href='pagination.php?limit=".$i."'>".$i."</a> ";
}


$calcul_position = ($get_limit - 1) * $nombre_par_page;

// récupération des résultats dans la table
$sql_liste = "SELECT designer_id as id, firstname as prenom, UPPER(lastname) as nom 
            FROM designer  
            ORDER BY lastname ASC, firstname ASC
            LIMIT ".$calcul_position.", ".$nombre_par_page.";";
print_q($sql_liste);
$result_liste = requeteResultat($sql_liste);


foreach($result_liste as $soustableau){
    $nom    = $soustableau["nom"];
    $prenom = $soustableau["prenom"];
    $id     = $soustableau["id"];

    echo $nom." ".$prenom."<br />";
}
?>
















