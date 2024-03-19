<?php
    class GestionAPI {
        private static $codeHTTP;
        // Prend en pamétre un tableau avec les Methods Autorisé
        // Vérifie que la méthode avec laquelle on fait appelle est contenu dans le tableau
        // Si n'est pas contenu renvoye une erreur 405
        public static function CheckMethod($allowedMethods)
        {
            
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            if (!in_array($requestMethod, $allowedMethods)) {
                http_response_code(405);
                header("Allow: " . implode(", ", $allowedMethods));
                // echo "Méthode non autorisée. Les méthodes autorisées sont: " . implode(", ", $allowedMethods);
                exit();
            }
        }
        //Retourne le body de la requête
        public static function GetRequestBody()
        {
            $allowedMethods = ['POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS','GET']; // Ajoutez toutes les méthodes nécessaires
            static::CheckMethod($allowedMethods);
            $requestData = file_get_contents('php://input');
            $decodedData = json_decode($requestData, true); // Vous pouvez ajuster le décodage en fonction du format des données (par exemple, JSON, XML, etc.)
            return $decodedData;
        }
        public static function setCodeHTTP($code) {
            self::$codeHTTP = $code;
    
            switch ($code) {
                case 200:
                    self::traiterCodeHTTP200();
                    break;
    
                case 400:
                    self::traiterCodeHTTP400();
                    break;
    
                case 403:
                    self::traiterCodeHTTP403();
                    break;
    
                // Ajoutez ici d'autres cas pour d'autres codes HTTP, si nécessaire
    
                default:
                    self::traiterCodeHTTPDefaut();
                    break;
            }
        }
    
        public static function getCodeHTTP() {
            return self::$codeHTTP;
        }
    
        public static function envoyerRequete() {
            // Envoyer la requête à l'API
            
            // Supposons que nous obtenons la réponse de l'API avec un code HTTP
            $responseCode = 404; // Exemple : Code HTTP 404 (Page non trouvée)
    
            if ($responseCode !== self::$codeHTTP) {
                http_response_code(self::$codeHTTP); // Modifier le code HTTP de la réponse
                exit(); // Arrêter l'exécution du script PHP
            }
    
            // Suite du traitement si le code HTTP de la réponse correspond au code souhaité
            // ...
        }
    
        private static function traiterCodeHTTPDefaut() {
            http_response_code(self::$codeHTTP); // Modifier le code HTTP de la réponse
            exit(); // Arrêter l'exécution du script PHP
        }
    
        private static function traiterCodeHTTP200() {
            // Traitement pour le code HTTP 200 (OK)
            // ...
        }
    
        private static function traiterCodeHTTP400() {
            // Traitement pour le code HTTP 400 (Mauvaise requête)
            // ...
        }
    
        private static function traiterCodeHTTP403() {
            // Traitement pour le code HTTP 403 (Accès refusé)
            // ...
        }
    
        // Ajoutez ici d'autres méthodes statiques pour d'autres codes HTTP, si nécessaire
    }
    
?>