<?php
// affichage de debugage -> print_r mis en forme
function print_q($val){
    echo "<pre style='background-color:#000;color:#3FBBD5;font-size:11px;z-index:99999;position:relative;'>";
    print_r($val);
    echo "</pre>";
}

function verifConnexion(){
    if((!isset($_SESSION["admin_id"])) || (empty($_SESSION["admin_id"]))|| (!is_numeric($_SESSION["admin_id"]))){
        header("Location: index.php?p=login");
        exit;
    }
}

function adminMenu(){
    if(isset($_SESSION["admin_id"])){
    ?>
    <div class="row">
        <nav class="nav-show">
            <div class="container">
                <ul>
                    <li><a href="index.php?p=admin_item">Gestion des pages</a></li>
                    <li><a href="index.php?p=admin_admin">Gestion des utilisateurs</a></li>
                    <li>
                        <a>Gestion du shop</a>
                        <ul>
                            <li><a href="index.php?p=admin_designer">Designer</a></li>
                            <li><a href="index.php?p=admin_manufacturer">Manufacturier</a></li>
                            <li><a href="index.php?p=admin_shape">Etat</a></li>
                            <li><a href="index.php?p=admin_delivery">Livraison</a></li>
                            <li><a href="index.php?p=admin_level1">Catégorie</a></li>
                            <li><a href="index.php?p=admin_level2">Sous-catégorie</a></li>
                            <li><a href="index.php?p=admin_ad">Fiche produit</a></li>
                        </ul>
                    </li>
                    <li>
                        <a>Mon compte</a>
                        <ul>
                            <li><a href="index.php?p=admin_password">Modifier mon mot-de-passe</a></li>
                            <li><a href="index.php?p=admin_unlog">D&eacute;connexion</a></li>
                        </ul>
                    </li>
                    <li class="u-pull-right"><a href="index.php?p=login">Login</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <?php
    
    }
}

function uploadImg($file, $path="") {
    $r = array();
    $r['warnmsg'] = "";
    if (isset($file['name']) AND $file['name'] != "") {
        $photo = date("YmdHis").".jpg";
        $tmp_file = $file["tmp_name"];
        // Upload du fichier image
        if (is_uploaded_file($tmp_file)) {
            $size = getimagesize($tmp_file);
            // Vérification de l'extension (2 = JPEG)
            if ($size[2] == 2) {
                // Upload et renommage
                move_uploaded_file($tmp_file, $path. $photo);
                //$r['warnmsg'] .= "<br />L'image a été insérée avec succès";
            } else {
                $r['warnmsg'] .= "<br />L'extension du fichier n'est pas valide.";
            }
        } else {
            $r['warnmsg'] .= "<br />Erreur lors de l'upload du fichier.";
        }
    } else {
        $r['warnmsg'] .= "<br />Pas d'image fournie.";
    }
    $r['photo'] = $photo;

    return $r;
}

/** /
 * Redimensionne et renomme l'image en fonction des parametres donnés
 * @param type $image = chemin de l'image sur le disque
 * @param type $largeur = future largeur de l'image
 * @param type $nom = futur nom de l'image
 * @return boolean
 */
function resize($image, $largeur, $nom, $file) {
    $image_origine = imagecreatefromjpeg($image);
    // Récupération des dimensions de l'image
    list($width, $height, $type, $attr) = getimagesize($image);
    // Calcul de la nouvelle hauteur
    $ratio = $width / $height;
    $hauteur = $largeur / $ratio;
    // Création d'un conteneur pour la nouvelle image
    $new_image = imagecreatetruecolor($largeur, $hauteur);
    if (!$new_image) {
        return false;
    } else {
        // Création de l'image dans les nouvelles dimensions et suppression de l'ancienne
        imagecopyresampled($new_image, $image_origine, 0, 0, 0, 0, $largeur, $hauteur, $width, $height);
        imagejpeg($new_image, $file.$nom, 100);
        imagedestroy($image_origine);
        return true;
    }
}

?>