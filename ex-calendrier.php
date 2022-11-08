<?php	
$annee = ["2021", "2022", "2023", "2024", "2025", "2026", "2027", "2028", "2029", "2030"];
$mois = ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];
$jour = ["Lu", "Ma", "Mer", "Je", "Ve", "Sa", "Di"];
$numero = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24",
         "25", "26", "27", "28", "29", "30"];
$cols = 7;

foreach($annee as $A){
	echo "<h1> $A </h1>";
	echo "<br/>";
foreach($mois as $m){
	echo "<h2> $m </h2>";
	echo "<table border ='1'>";
	  echo "<tr>";
	foreach($jour as $j){
	  echo "<td>".$j."</td>";
	}
	  echo "</tr>";
	  echo "<tr>";
	foreach($numero as $D){
	  echo "<td>".$D."</td>";
	}
	  echo "</tr>";
	echo "</table>";
}
}


?>