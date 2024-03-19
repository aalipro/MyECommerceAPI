<?php
require_once('./CONFIG/connexion.php');
require_once('./CONTROLLER/ControleurObjet.php');
require_once("./MODEL/Objet.php");
Connexion::connect();
echo "<pre>";
Connexion::pdo();
echo "</pre>";

if (!isset($_GET["action"])) {
  $action = "lireObjets";
} else {
  $action = $_GET["action"];
}

if (!isset($_GET["objet"])) {
  $objet = "Client";
} else {
  $objet = $_GET["objet"];
}
require_once("./MODEL/$objet.php");
require_once("./CONTROLLER/Controleur$objet.php");


/* Pour lire les fichiers se trouvant dans le fichier MODELE et récupérer le
  nom de chaque classe
// $dir = './MODEL';
// $files = scandir($dir);

// $lesClasses = array();
// echo "<pre>";var_dump(get_class_vars("Client")); echo "</pre>";
// foreach($files as $file) {
//     // Vérifier si le nom de fichier n'est pas "." ou ".."
//     if($file !== '.' && $file !== '..' && $file != ".gitkeep") {
//         // echo $file . "\n";
//         $lesClasses[] = explode(".", $file)[0];
//         // echo "<p>".explode(".", $file)."</p>";
//     }
// }
include("./VIEW/menu.php");
*/
// echo "<p> action = ".$action."</p>";
// echo "<p> objet = ".$objet."</p>";
$controleur = "Controleur$objet";

try{
  $resultat = $controleur::$action();
  $response[
    "status"=> "1",
    "resultat" => $resultat,
    "message" => "Requête exécuté avec succés";
  ]
}
catch(Exception $e){
  $response[
    "status"=> "0",
    "resultat" => $resultat;
    "message" => "Echec de la requête"
  ]
}
?>