<?php
function removeSpecialChar($s){
    // remplace les espace par des tirets
    $s = strtolower(str_replace(' ', '', $s));
    // retourne en enlevant tous les caractères spéciaux
    return preg_replace('/[^A-Za-z0-9\_]/', '_', $s);
}

function form($id, $action, $method, $content, $select, $textarea, $class = ""){
    $superglobale = strtoupper($method) == "POST" ? $_POST : $_GET;

    $show_form      = array();
    $show_form[]    = sizeof($superglobale) == 0 ? true : false;

    $msg            = "";
    $form           = "\n";
    $form_class     = !empty($class) ? " class=\"".$class."\"" : "";
    $form .= "<form action=\"".$action."\" method=\"".$method."\" id=\"".$id."\"".$form_class.">\n";

    foreach($select as $c){
        $required   = isset($c["check"]) ? $c["check"] : true;
        $info_msg   = isset($c["label"]) ? "<b>Erreur:</b> ".$c["label"]." est manquant" : "Information manquante";
        $info_msg   = isset($c["error"]) && !empty($c["error"]) ? "<b>Attention:</b> ".$c["error"] : $info_msg;
        $class_msg  = isset($c["error"]) && !empty($c["error"]) ? "warning" : "error";
        $form      .= $c["select"].((!$required && !empty($superglobale)) ? "\t<p class=\"missingfield ".$class_msg."\"> ".$info_msg."</p>" : "");
        $form .= "\t</div>\n";
        $show_form[] = isset($c["check"]) && $c["check"] == false ? true : false;

    }
    
    foreach($textarea as $c){
        $required   = isset($c["check"]) ? $c["check"] : true;
        $info_msg   = isset($c["label"]) ? "<b>Erreur:</b> ".$c["label"]." est manquant" : "Information manquante";
        $info_msg   = isset($c["error"]) && !empty($c["error"]) ? "<b>Attention:</b> ".$c["error"] : $info_msg;
        $class_msg  = isset($c["error"]) && !empty($c["error"]) ? "warning" : "error";
        $form      .= $c["textarea"].((!$required && !empty($superglobale)) ? "\t<p class=\"missingfield ".$class_msg."\"> ".$info_msg."</p>" : "");
        $form .= "\t</div>\n";
        $show_form[] = isset($c["check"]) && $c["check"] == false ? true : false;

    }

    $form .= "</form>\n";
    $msg = in_array(true, $show_form) && sizeof($superglobale) > 0 ? "\t<p class=\"missingfield notice\"> <b>Attention:</b> Certains champs ont été oubliés ou sont mal remplis. Veuillez corriger.</p>" : "";
    return in_array(true, $show_form) ? $msg.$form : false;
}

function addSelect($label, $properties, $post_select, $required = false, $div_class = ""){
    $type   = isset($properties["type"]) && !empty($properties["type"]) ? $properties["type"] : "text";
    $check  = true;
    $error  = "";
    $id     = $label;
    $id     = removeSpecialChar($id);
    if($required){
        $check  = isset($post_select) && !empty($post_select) ? true : false;
    }
    $select = "\n";
    $select .= "\t<div".(!empty($div_class) ? " class=\"".$div_class."\"" : "").">\n";
    $select .= "\t\t<label for=\"".$id."\">\n";
    $select .= "\t\t\t".$label." ".($required ? "<span class=\"missingstar\">&#10036;</span>" : "")."\n";
    $select .= "\t\t</label>\n";

    $s = "";
    foreach($properties as $key => $value){
        $s .= " ".$key."=\"".$value."\"";
    }
    $select .= "\t\t<select id=\"".$id."\"".$s." />\n";
    return array("select" => $select, "check" => $check, "label" => $label, "error" => $error);
}

function addTextarea($label, $properties, $post_description, $required = false, $div_class = ""){
    $type   = isset($properties["type"]) && !empty($properties["type"]) ? $properties["type"] : "text";
    $check  = true;
    $error  = "";
    $id     = $label;
    $id     = removeSpecialChar($id);
    if($required){
        $check  = isset($post_description) && !empty($post_description) ? true : false;
    }

    $textarea = "\n";
    $textarea .= "\t<div".(!empty($div_class) ? " class=\"".$div_class."\"" : "").">\n";
    $textarea .= "\t\t<label for=\"".$id."\">\n";
    $textarea .= "\t\t\t".$label." ".($required ? "<span class=\"missingstar\">&#10036;</span>" : "")."\n";
    $textarea .= "\t\t</label>\n";

    $s = "";
    foreach($properties as $key => $value){
        $s .= " ".$key."=\"".$value."\"";

    }
    $textarea .= "\t\t<textarea id=\"".$id."\"".$s." ></textarea>\n";

    return array("textarea" => $textarea, "check" => $check, "label" => $label, "error" => $error);
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