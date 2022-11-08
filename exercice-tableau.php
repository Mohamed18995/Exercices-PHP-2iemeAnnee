<?php 
/* 1) créez un tableau "indicé" à une dimension qui contiendra 8 noms;

      a) bouclez sur ce tableau pour afficher chacune des données

      b) idem mais passez à la ligne chacune des données

      c) idem mais affichez chacune des données dans une balise <p> différente

      d) idem mais dans une liste ordonnée => <ol><li>
*/
   // 1)
   $noms = ['pierre', 'mohamed', 'jean', 'cathrine', 'mathilde', 'marcelle', 'ahmad', 'benoit'];
   $cpt = 0;
   // a
   foreach($noms as $valeur){
	   if($cpt > 0){
		   echo ", ";
	   }
	echo $valeur;
	$cpt++;
   }
   	echo " <br> <br>";
   //b
    foreach($noms as $valeur){
	echo $valeur." <br>";
    }
	echo " <br> <br>";
   // c
   foreach($noms as $valeur){
	echo "<p> $valeur </p> ";
   }
   
   // d
   
   echo "<ol>";
   foreach($noms as $valeur){
	echo "<li> $valeur </li> ";
   }
   echo "</ol>";
 
 //  2
 /*
    2) créez un tableau "associatif" contenant 7 pays ;

      a) bouclez sur ce tableau pour afficher chacune des données dans une liste html

      b) ajouter 1 nouveau pays dans le tableau puis boucler à nouveau -> liste html

      c) idem mais en ajoutant 3 nouveaux pays 
 */
 // a
   
   $pays = [ 1 => 'Belgique', 2 =>'Allemagne', 3 =>'France', 4 =>'Pays-bas', 5 =>'Danemark', 6 =>'Autriche', 7 =>'Italie' ];
 
 // b
 echo "<ul>";
 foreach($pays as $valeur){
	   echo "<li> $valeur </li>";
   }
  echo "</ul>"; 
   //c
   
   $pays[7] = "Croatie";
   echo $pays[7];
   
   
   /*
     3) créez un tableau carnet d'adresses qui contiendra les informations suivantes

	- nom 

	- prénom

	- adresse postale

	- email

	- numéro de téléphone

   a) Bouclez sur ce tableau pour afficher les informations contenues (/!\ n'oubliez pas d'afficher les clés associées)

   b) idem mais en affichant le nom en majuscule et la première lettre du prénom en majuscule et le reste en minuscule.
   */
   // 3
   $carnet =[];
   $carnet["nom"] = "alshahoud";
   $carnet["prénom"] = "mohamed";
   $carnet["adresse"] = "quai de rome 99";
   $carnet["numero gsm"] = "0489470853";
   //a
   foreach($carnet as $clef => $valeur){
	   echo $clef." ".$valeur." <br />";  
   }
   echo " <br> <br>";
   // b
   foreach($carnet as $clef => $valeur){
	   if($clef == "prenom"){
		   $valeur = ucwords($valeur);
	   }else if($clef == "nom"){
		   $valeur = strtoupper($valeur);
	   }
	   echo $clef." ".ucwords($valeur)." <br />";  
   }
?>