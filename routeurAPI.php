<?php
require_once('./CONFIG/connexion.php');
require_once('./CONTROLLER/ControleurObjet.php');
require_once("./MODEL/Objet.php");
Connexion::connect();
echo "<pre>";
Connexion::pdo();
echo "</pre>";
if (isset($_GET['objet'])) {
  $objet = $_GET['objet'];
} else {
  $objet = "Client";
}
require_once("./CONTROLLER/$objet.php");
if (!isset($_GET["action"])) {
  $action = "lireObjets";
} else {
  $action = $_GET["action"];
}

// require_once("./MODEL/Prestataire.php");
require_once("./MODEL/$objet.php");
echo "<p> action = ".$action."</p>";
echo "<p> controleur = ".$controleur."</p>";
// $controleur::$action();
$dir = './MODEL';
$files = scandir($dir);

$lesClasses = array();
foreach($files as $file) {
    // Véri                                r si le nom de fichier n'est pas "." ou ".."
    if($file !== '.' && $file !== '..' && $file != ".gitkeep") {
        // echo $file . "\n";
        $lesClasses[] = explode(".", $file)[0];
        // echo "<p>".explode(".", $file)."</p>";
    }
}
// include("./VIEW/menu.php");
$params = $GET["params"];
$controleur::$action();
?>