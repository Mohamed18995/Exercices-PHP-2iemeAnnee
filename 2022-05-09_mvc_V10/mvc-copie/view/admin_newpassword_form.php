<?php

echo !empty($msg) ? "<div class='missingfield ".$msg_class."'><ul>".$msg."</ul></div>" : "";

echo $show_form;
?>