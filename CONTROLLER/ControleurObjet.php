<?php
    class ControleurObjet{
        public static function lireObjets(){
            $objet = static::$objet;
            $cle = static::$cle;
            
            $tableau = $objet::getAllObjets();
            return $tableau;
        }

        public static function lireObjet(){
            $titre = "le ".strtolower(static::$objet);

            $num = $_GET[static::$cle];
            $objet = static::$objet::getObjetById($num);
            return $objet;
        }

        public static function creerObjet(){
            $table = static::$objet;
            $tabAttributs = array();
            foreach(static::$tableauChamps as $attribut => $type){
                $tabAttributs[$attribut] = $_GET[$attribut];
            }
            $confirmation = $table::addObjet($tabAttributs);

            return $confirmation;
            // if($confirmation){
            //     echo "Ajout $table réussit !";
            // }
            // else{
            //     echo "Ajout $table raté!";
            // }
        }

        public static function supprimerObjet(){
            $table = static::$objet;
            $cle = static::$cle;
            $id = $_GET[$cle];
            
            $confirmation = $table::deleteObjetById($id);
            return $confirmation;
            // if($confirmation){
            //     echo "Suppression $table réussit !";
            // }
            // else{
            //     echo "Suppression $table raté!";
            // }
        }
        public static function modifierObjet(){
            $table = static::$objet;
            $tabAttributs = array();
            foreach(static::$tableauChamps as $attribut => $type){
                $tabAttributs[$attribut] = $_GET[$attribut];
            }
            $tabAttributs[static::$cle] = $_GET[static::$cle];
            $confirmation = $table::updateObjet($tabAttributs);

            if($confirmation){
                echo "Modification $table réussit !";
            }
            else{
                echo "Modification $table raté!";
            }
        }
    }
?>