<?php
    require_once("./MODEL/Client.php");
    // require_once("./MODEL/PersonnelAdministratif.php");
    // require_once("./MODEL/ProfessionnelSante.php");
    class ControleurUtilisateur{

        public static function seConnecter(){
        $mail = $_GET["mail"];
        $mdp = $_GET["mdp"];
        $dicoClient = ["mailClient" => $mail,
                 "mdpClient" => $mdp    
        ];
        $obj = Client::getObjetsByParams($dicoClient);
        $tab = array();
        //On vérifie 
        $tab["connexionReussie"] = true;
        if($obj != null){
            $tab["objet"] =$obj[0] ;
            return $tab;
        }

        $dicoCPersonelPersonelAdministratif= ["mail" => $mail,
                 "mdpPersonelAdministratif" => $mdp    
        ];

        $obj = PersonnelAdministratif::getObjetsByParams($dicoCPersonelPersonelAdministratif);
        if($obj != null){
            $tab["objet"] =$obj[0] ;
            return $tab;
        }
        $dicoProfessionnelSante = ["mailProfessionnelSante" => $mail,
                 "mdpProfessionnelSante" => $mdp    
        ];

        $obj = ProfessionnelSante::getObjetsByParams($dicoProfessionnelSante);
        if($obj != null){
            $tab["objet"] =$obj[0] ;
            return $tab;
            return $obj[0];
        }
        $tab["connexionReussie"] = false;
        return $tab;
        }
    }