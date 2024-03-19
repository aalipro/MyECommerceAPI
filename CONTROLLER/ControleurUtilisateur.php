<?php
    require_once("./MODEL/Client");
    require_once("./MODEL/PersonelAdministratif");
    require_once("./MODEL/ProfessionnelSante");
    class ControleurUtilisateur{
        $mail = $_GET["mail"];
        $mdp = $_GET["mdp"];
        $dicoClient = ["mailClient" => $mail,
                 "mdpClient" => $mdp    
        ];
        $obj = Client::getObjetByParams($dicoClient);
        //On vérifie 
        if(/*Condition pour voir si un obj n'a rien renvoyé*/ ){
            return $obj[0];
        }

        $dicoCPersonelPersonelAdministratif= ["mail" => $mail,
                 "mdpPersonelAdministratif" => $mdp    
        ];

        $obj = PersonelAdministratif::getObjetByParams($dicoCPersonnelAdminin);
        if(/*Condition pour voir si un obj n'a rien renvoyé*/){
            return $obj[0];
        }
        $dicoProfessionnelSante = ["mailProfessionnelSante" => $mail,
                 "mdpProfessionnelSante" => $mdp    
        ];

        $obj = ProfessionnelSante::getObjetByParams($dicoProfessionnelSante);
        if(/*Condition pour voir si un obj n'a rien renvoyé*/){
            return $obj[0];
        }

        return "email ou mot de passe incorrect";
    }
?>