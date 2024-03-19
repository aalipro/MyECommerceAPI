<?php
  echo "<nav>";
  foreach($lesClasses as $uneClasse)
  echo "<div><a href='routeur.php?controleur=Controleur$uneClasse&action=lireObjets'>Tous les $uneClasse </a><div>";
  echo "</nav>";
?>