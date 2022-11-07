<?php

foreach($result as $r){
    $nom = $r["lastname"];
    $id = $r["designer_id"];

    echo "<p>".$id." ) ".$nom."</p>";
}

?>