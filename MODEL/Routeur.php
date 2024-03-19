<?php
    class Routeur{
        public function __construct(){
        }
        public static $cheminVersControleur = './CONTROLLER';
        public static $cheminVersModel = './MODEL';
        public function getLesControleurs(){
            return $this->getClassInPath(self::$cheminVersControleur);
        }
        public function getLesModels(){
            return $this->getClassInPath(self::$cheminVersModel);
        }
        public function getClassInPath($path){
            $fichiers = scandir($path);
            $_lesClasses = [];
            $lesClasses = [];
            // Parcourez chaque fichier trouvé
            foreach ($fichiers as $fichier) {
                // Excluez les fichiers "." et ".." qui représentent le répertoire courant et parent
                if ($fichier !== '.' && $fichier !== '..') {
                    $extension = pathinfo($fichier, PATHINFO_EXTENSION);
                    if ($extension === 'php') {
                        $nomFichier = pathinfo($fichier, PATHINFO_FILENAME);
                        try {
                            require_once("$path/$nomFichier.php");
                        } catch (Throwable $e) {
                            // echo 'Caught exception: ' . $e->getMessage();
                        }
                        if (class_exists($nomFichier)) {
                            // echo "La classe $nomClasse existe." . PHP_EOL;
                            $lesClasses[] = $nomFichier;
                        } else {
                            // echo "La classe $nomClasse n'existe pas." . PHP_EOL;
                        }
                    }
                    
                }
            }
            return $lesClasses;
        }
        public function getActionAndObjet(){
            $actionAndObjet= ["objet"=>null, "action"=>null];
            $requestUri = $_SERVER['REQUEST_URI'];
            $requestUri = explode("?", $requestUri);
            $requestUri = explode("index.php/", $requestUri[0]);
            $lesControleurs = $this->getLesControleurs();
            if (count($requestUri) === 2) {
                $requestUri = $requestUri[1];
                $lesPara = explode("/", $requestUri);
                $countLesPara = count($lesPara);
                if( $countLesPara > 3 || $countLesPara<2){
                    http_response_code(404);
                    exit();
                }
                $objet  = $lesPara[0];
                $objetExistant = in_array("Controleur$objet", $lesControleurs);
                if($objetExistant){
                    $actionAndObjet["objet"] = $objet;
                    $action = $lesPara[1];
                    $lesMethodes = $this->getMethodsOf("Controleur$objet");
                    $actionExistant = in_array($action, $lesMethodes);
                    if($actionExistant){
                        $actionAndObjet["action"] = $action;
                    }
                }
            }
            return $actionAndObjet;
        }
        public static function getID(){
            try{
                $requestUri = $_SERVER['REQUEST_URI'];
                $requestUri = explode("index.php", $requestUri);
                $requestUri = $requestUri[1];
                $lesPara = explode("/", $requestUri);
                $ID = NULL;
                $COUNT = count($lesPara);
                if(count($lesPara) === 4){
                    $ID = $lesPara[3];
                }
            }catch (Exception $e) {
                $errorMessage = $e->getMessage();
            }
            return $ID;
        }  
        function getMethodsOf($nomClasse) {
            $reflection = new ReflectionClass($nomClasse);
            $methodNames = [];
            $methods = $reflection->getMethods();
            foreach ($methods as $method) {
                $methodNames[] = $method->getName();
            }
            return $methodNames;
        }
        function getAttributesOf($nomClasse) {
            $reflection = new ReflectionClass($nomClasse);
            $attributeNames = [];
        
            $attributes = $reflection->getProperties();
            foreach ($attributes as $attribute) {
                $attributeNames[] = $attribute->getName();
            }
            return $attributeNames;
        }    
        public function getApiJson(){
            $lesControleurs = $this->getLesControleurs();
            $dicControleurFonction = [];
            foreach($lesControleurs as $controleur){
                if($controleur != 'ControleurObjet'){
                    $nomClass = explode('Controleur', $controleur)[1];
                    $methods = $this->getMethodsOf($controleur);
                    $attributs = $this->getAttributesOf($nomClass);
                    $attributs = $this->supprimerCleEtType($attributs);

                    $dicControleurFonction[$nomClass] = [
                        "methods" => $methods,
                        "attributs" => $attributs,
                    ];
                }
            }
            return $dicControleurFonction;
        }
        private function supprimerCleEtType($tab){
            $indice = array_search("cle", $tab);
            if($indice != null){
                unset($tab[$indice]);
            }
            $indice = array_search("type", $tab);
            if($indice != null){
                unset($tab[$indice]);
            }
            return $tab;
        }

        public function TestRouteur(){
            $lesControlleurs = $this->getLesControleurs();
            $lesModels = $this->getLesModels();
            extract($this->getActionAndObjet());
            if($objet === "Objet" && $action="getApiJson"){
                echo json_encode($this->getApiJson());
                exit();
            }
            elseif($objet === null || $action === null){
                http_response_code(400);
                exit();
                //throw new Exception("ACTION OU OBJET INEXISTANT");
            }
            
            $objet = "Controleur$objet";
            try{
                $res= $objet::$action();
                $response = [
                    "status"=> "1",
                    "resultat" => $res,
                    "typeOfResultat" => gettype($res),
                    "message" => "Requête exécutée avec succès"
                ];
            }
            catch(Exception $e){
                $response = [
                    "status"=> "0",
                    "resultat" => null,
                    "typeOfResultat" => gettype($e),
                    "message" => "Requête échouée",
                    "error" => $e->getMessage()
                ];
            }
            
            echo json_encode($response);
            exit();
        }

    }
?>