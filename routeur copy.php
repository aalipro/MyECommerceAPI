<?php
require_once('./CONFIG/connexion.php');
require_once('./CONTROLLER/ControleurObjet.php');
require_once("./MODEL/Objet.php");
Connexion::connect();
echo "<pre>";
Connexion::pdo();
echo "</pre>";
if (isset($_GET['controleur'])) {
  $controleur = $_GET['controleur'];
} else {
  $controleur = "ControleurClient";
}
require_once("./CONTROLLER/$controleur.php");
if (!isset($_GET["action"])) {
  $action = "getAllObjets";
} else {
  $action = $_GET["action"];
}

if (!isset($_GET["objet"])) {
  $objet = "Client";
} else {
  $objet = $_GET["objet"];
}
require_once("./MODEL/$objet.php");
echo "<p> action = ".$action."</p>";
echo "<p> controleur = ".$controleur."</p>";
// $controleur::$action();
$dir = './MODEL';
$files = scandir($dir);

$lesClasses = array();
foreach($files as $file) {
    // Vérifier si le nom de fichier n'est pas "." ou ".."
    if($file !== '.' && $file !== '..') {
        echo $file . "\n";
        if($file != ".gitkeep")
        $lesClasses[] = $file;
    }
}
include("./VIEW/menu.php");
// $tableau = $objet::$action();
// echo json_encode($tableau);
// echo "<pre>";
// var_dump(	$tableau);
// echo "</pre>";
?>