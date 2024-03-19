<?php
    require_once("./MODEL/Routeur.php");
    class ControleurObjet{
        public static function GET(){
            $allowedMethods = ["GET"];
            GestionAPI::CheckMethod($allowedMethods);
            if(count($_GET) >0){
                return static::GetWithParams();
            }
            $ID = Routeur::getID();
            if($ID!=NULL){
                return static::GetId($ID);
            }
            $cle = static::$cle;
            $tableau = static::$objet::getAllObjets();
            $tab = json_encode($tableau);
            return $tableau;
        }

        private static function GetId($id){
            $objet = static::$objet::getObjetById($id);
            return $objet;
        }
        public static function GetWithParams(){
            $objet = static::$objet;
            return $objet::getObjetsByParams($_GET);
        }
        public static function POST(){
            // ON vérifie que c'est une méthoe POST qui est utilisé
            $allowedMethods = ["POST"];
            GestionAPI::CheckMethod($allowedMethods);
            //On récupére les données de la requête
            $leBody = GestionAPI::GetRequestBody();
            try{
                // On crée un objet
                $objet = static::$objet;
                $objPosted = new $objet($leBody);
                // $objPosted->save();
                return static::$objet::updateObjet($leBody);
            }
            catch(Exception $e){
                return "ERROR".$e->getMessage();
            }
        }
        public static function PUT(){
            // ON vérifie que c'est une méthoe POST qui est utilisé
            $allowedMethods = ["PUT"];
            GestionAPI::CheckMethod($allowedMethods);
            //On récupére les données de la requête
            $leBody = GestionAPI::GetRequestBody();
            try{
                // On crée un objet
                $objet = static::$objet;
                $objPosted = new $objet($leBody);
                // $objPosted->save();
                return static::$objet::updateObjet($leBody);
            }
            catch(Exception $e){
                return "ERROR".$e->getMessage();
            }
        }

        public static function supprimerObjet(){
            $table = static::$objet;
            
            $id = $_GET["id"];
            $confirmation = $table::deleteObjetById($id);
            return $confirmation;
            // if($confirmation){
            //     echo "Suppression $table réussit !";
            // }
            // else{
            //     echo "SuppressimodifierObjeton $table raté!";
            // }
        }
        public static function modifierObjet(){
            $reflect = new ReflectionClass(static::$objet);
            $props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE);
            $params = $_GET["params"];
            $params = json_decode($params);
            $params2 = array("emailAdmin" => "aheathcoat2@seattletimes.com");
            $attributs = array();
            $lesNomAttributsClasses = array();
            foreach ($props as $prop) {
                $nomAttribut = $prop->getName();
                $lesNomAttributsClasses[] = $nomAttribut;
            }
            $lesAttributs = array();
            $clePresente = false;
            foreach($params as $attribut => $valeur){
                if(in_array($attribut, $lesNomAttributsClasses)){

                    $lesAttributs[$attribut] = $params->{$attribut};
                    if($attribut == static::$cle) {
                        $clePresente= true;
                    }                                                 
                }
                else{
                    throw new Exception("$attribut n'est pas un attribut de classe " .static::$objet);
                }
            }
            if($clePresente == false){
                throw new Exception("Il faut faire figurer  " .static::$cle ." dans les les paramétres");
            }
            return static::$objet::updateObjet($lesAttributs);
        }
        
        public static function lireObjetsByParams(){
            $reflect = new ReflectionClass(static::$objet);
            $props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE);
            $params = $_GET["params"];
            $params = json_decode($params);
            $params2 = array("emailAdmin" => "aheathcoat2@seattletimes.com");
            $attributs = array();
            $lesNomAttributsClasses = array();
            foreach ($props as $prop) {
                $nomAttribut = $prop->getName();
                $lesNomAttributsClasses[] = $nomAttribut;
            }
            $lesAttributs = array();
            foreach($params as $attribut => $valeur){
                if(in_array($attribut, $lesNomAttributsClasses)){
                    $lesAttributs[$attribut] = $params->{$attribut};
                }
                else{
                    throw new Exception("$attribut n'est pas un attribut de classe " .static::$objet);
                }
            }
            return static::$objet::getObjetsByParams($lesAttributs);
            //https://projets.iut-orsay.fr/prj-prism/BACK/routeur.php?objet=RendezVous&action=lireObjetsByParams&params=
        }
        public static function test(){
            $objet = static::$objet;
            // $tableauSelect = $tabObjetAttribut['select'];
			// $tabColonesAJoindre = $tabObjetAttribut['colones'];
			// $tabConditionJointure = $tabObjetAttribut['conditionsJointure'];
			// $tabConditions = $tabObjetAttribut['conditions'];
            $tabObjetAttribut = [
                "select" => ["Ville.nom", "Client.nom", "Client.prenom"],
                "colones" => ["Ville", "Client"],
                "conditions" => ["Client.idClient = Alias"],
                "conditionsJointure" =>["Ville.idVille = Client.idVille"]
            ];
            $res = Objet::buildRequestGetByJointure($tabObjetAttribut);
            //echo "<h1>$res</h1>";
            return $res;
        }
    }