<?php

if(isset($_GET["nom"]) && isset($_GET["prenom"]) && isset($_GET["age"]){

    $nom= $_GET["nom"];
    $prenom  = $_GET["prenom"];
    $age    = $_GET["age"];

    if(empty($nom) || empty($prenom) || empty($age)){
        echo "Attention, au moins un champs obligatoire n'a pas été rempli";
        if(empty($nom)){
            echo "<p>le champs nom est manquant</p>";
        }
        if(empty($prenom)){
            echo "<p>le champs prenom est manquant</p>";
        }
        if(empty($age)){
            echo "<p>le champs age est manquant</p>";
        }

    }else{
        echo "<p>Votre inscription est validée</p>";
    }

}else{
    echo "<p>Une erreur est survenue et un ou plusieurs champs n'existe(nt) pas !</p>";
}





?>