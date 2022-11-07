<?php
function removeSpecialChar($s){
    // remplace les espace par des tirets
    $s = strtolower(str_replace(' ', '', $s));
    // retourne en enlevant tous les caractères spéciaux
    return preg_replace('/[^A-Za-z0-9\_]/', '_', $s);
}

function form($id, $action, $method, $content, $class = ""){
    $superglobale = strtoupper($method) == "POST" ? $_POST : $_GET;

    $show_form      = array();
    // le formulaire doit-il être affiché ?
    // si le formulaire n'a pas encore été soumis alors il faut l'afficher
    $show_form[]    = sizeof($superglobale) == 0 ? true : false;

    // initialisation des variables + construction du formulaire
    $msg            = "";
    $form           = "\n";
    $form_class     = !empty($class) ? " class=\"".$class."\"" : "";
    $form .= "<form action=\"".$action."\" method=\"".$method."\" id=\"".$id."\"".$form_class.">\n";

    // boucle sur les différents éléments constituant le formulaire mise er forme (html) et champs
    foreach($content as $c){
        // vérifier l'état du champ (si il est correctement rempli). Si ce n'est pas spécifié, on considère qu'il l'est
        $required   = isset($c["check"]) ? $c["check"] : true;
        // création du message d'erreur
        $info_msg   = isset($c["label"]) ? "<b>Erreur:</b> ".$c["label"]." est manquant" : "Information manquante";
        // si il y a un message d'erreur, on l'affiche
        $info_msg   = isset($c["error"]) && !empty($c["error"]) ? "<b>Attention:</b> ".$c["error"] : $info_msg;
        // affichage d'une classe différente suivant qu'il s'agisse d'un champ manquant ou d'un champ mal rempli
        $class_msg  = isset($c["error"]) && !empty($c["error"]) ? "warning" : "error";
        // affichage du champ suivi de l'eventuel message d'erreur
        $form      .= $c["input"].((!$required && !empty($superglobale)) ? "\t<p class=\"missingfield ".$class_msg."\"> ".$info_msg."</p>" : "");
        $form .= "\t</div>\n";
        // si le champ doit être rempli et qu'il ne l'est pas, on insère true dans le tableau $show_form
        $show_form[] = isset($c["check"]) && $c["check"] == false ? true : false;
    }

    $form .= "</form>\n";

    // si au moins un true est trouvé dans le array show_form : création d'un message d'erreur général
    $msg = in_array(true, $show_form) && sizeof($superglobale) > 0 ? "\t<p class=\"missingfield notice\"> <b>Attention:</b> Certains champs ont été oubliés ou sont mal remplis. Veuillez corriger.</p>" : "";
    // si au moins un true est trouvé dans le array show_form : ré-affichage du formulaire MAIS avec le message d'erreur
    // si aucun true alors return de false et soumission complète du form
    return in_array(true, $show_form) ? $msg.$form : false;
}
// ajout d'input
function addInput($label, $properties, $required = false, $div_class = ""){
    // vérification : le type est-il définit ? sinon l'attribut "text" est attribué par défaut
    $type   = isset($properties["type"]) && !empty($properties["type"]) ? $properties["type"] : "text";
    // initialisation de la variable check qui va servir lors de la vérification du champ
    // initialisation à true (est valide) => passera à false si le champ doit être vérifié et qu'il est vide
    $check  = true;
    // initialisation de la variable error qui contiendra le message d'erreur éventuel
    $error  = "";
    // afin d'éviter les doublons et/ou les erreurs, un nom d'id sera généré automatiquement à partir du nom du label
    $id     = $label;
    // suppression des caractères spéciaux pour éviter tout problème
    $id     = removeSpecialChar($id);

    // si le paramètre $need vaut true, vérification du contenu de la value du champ
    if($required){
        // si le champ est empty check vaudra false sinon check vaudra true
        $check  = isset($properties["value"]) && !empty($properties["value"]) ? true : false;
        // cette information sera renvoyée à la fin de l'exécution de la fonction
    }

    // création du html de l'input en rapport avec les informations collectées
    $input = "\n";
    $input .= "\t<div".(!empty($div_class) ? " class=\"".$div_class."\"" : "").">\n";
    $input .= "\t\t<label for=\"".$id."\">\n";
    // si la variable need vaut true alors affichage d'une * pour marquer le champ comme obligatoire
    $input .= "\t\t\t".$label." ".($required ? "<span class=\"missingstar\">&#10036;</span>" : "")."\n";
    $input .= "\t\t</label>\n";

    $s = "";
    // il faut boucler sur le tableau properties pour en extraire toutes les informations
    foreach($properties as $key => $value){
        $s .= " ".$key."=\"".$value."\"";
    }
    // définition de l'input et attribution des propriétés
    $input .= "\t\t<input id=\"".$id."\"".$s." />\n";
    // fin de la création de l'input

    // un tableau est retourné
    /*
     * input => code html généré
     * check => le champ est-il correctement rempli (true/false)
     * label => label correspondant
     * error => une erreur doit-elle être affichée ?
     *
     */
    return array("input" => $input, "check" => $check, "label" => $label, "error" => $error);
}

function addTextarea(){

}

function addSubmit($properties){
    $input = "\n";

    $s = "";
    foreach($properties as $key => $value){
        $s .= " ".$key."=\"".$value."\"";
    }

    $input .= "\t<div>\n";
    $input .= "\t\t<input type=\"submit\"".$s." />\n";

    return array("input" => $input, "check" => true);
}


?>