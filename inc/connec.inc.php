<?php
// //Creation/ouverture du fichier de session
// session_start(); 

//---------------------------------------------------------------
//Connexion à la BDD 'cinema'
$pdo = new PDO('mysql:host=localhost;dbname=cinema', 'wac', 'root' , array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING) );

//var_dump( $pdo );
//---------------------------------------------------------------
//Définition d'une constante :
define( 'URL', 'http://localhost/Projet_cinema/');
//correspond à l'URL de la racine de notre site

//---------------------------------------------------------------
//définition de variables : 
$content = ''; //variable prévue pour recevoir du contenu
$error = ''; //variable prévue pour recevoir les messages d'erreurs

//---------------------------------------------------------------
//Inclusion des fonctions :



// //---------------------------------------------------------------
//Autre methode:


// $localhost 	= "localhost"; 
// $username 	= "wac"; 
// $password 	= "root"; 
// $dbname 	= "cinema";

// $dsn = "mysql:host=$host;dbname=$dbname"; 

 
// try{
//  $pdo = new PDO($dsn, $username, $password);

//  if($stmt === false){
//   die("Erreur");
//  }
 
// }catch (PDOException $e){
//   echo $e->getMessage();
// }

?>
