<?php
include_once("base/fonction.php");

$post_pays           = isset($_POST["pays "])          ? filter_input(SELECT_POST, 'pays ', FILTER_SANITIZE_SPECIAL_CHARS)            : null;
$post_description    = isset($_POST["description"])    ? filter_input(TEXTAREA_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS)      : null;

$input = [];
$select = [];
$textarea = [] ;

$select[]   = addSelect('Pays', array("name" => "pays", "class" => "u-full-width"), array("" => "=== choix ===", "BE" => "Belgique", "FR" => "France", "LU" => "Luxembourg"), "BE", true);
$textarea[]   = addTextarea('Parcours du designer', array("name" => "description","value" => $post_description, "class" => "u-full-width"), $post_description, true);

$input[] = addSubmit(["value" => "envoyer", "name" => "submit"]);

$show_form = form("form_contact", "form_designer.php", "post", $input, $select, $textarea );

if($show_form != false){
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">

    <head>
        <title><?php echo isset($page_title) ? $page_title : ""; ?></title>
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
    <div class="container" id="content">
        <?php
        echo $show_form;
        ?>
    </div>
    </body>
    </html>
    <?php
}else{

}
?>
