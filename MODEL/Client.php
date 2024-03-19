<?php
    Class Client extends Objet{
        public $mailClient;
        public $mdpClient;
        public $nomClient;
        public $pseudoClient;
        public $prenomClient;
        public $dateNaissanceClient;
        public $adresseCompleteClient;
        public $idAdresse;
        // public $telephoneClient;
        // public $type ="Client";

        protected static $objet = "Client";
		protected static $cle = "mailClient";

        public static function inscription(){
            return static::POST();
        }
        public function addComm($note, $comm, $idRdv, $adresseMail) {
            $requetePreparee = "INSERT INTO Avis Values(:tag_note, :tag_comm, :tag_id, :tag_adrMail);";
		    $req_prep = Connexion::pdo()->prepare($requetePreparee);
		    // le tableau des valeurs
		    $valeurs = array(
                "tag_note" => $note,
                "tag_comm" => $comm,
                "tag_id" => $idRdv,
                "tag_adrMail" => $adresseMail
            );
		    try {
			    // envoi de la requête
			    $req_prep->execute($valeurs);
			    // traitement de la réponse
                $req_prep->setFetchmode(PDO::FETCH_CLASS,'Avis');
                // récupération de l'auteur
                $a = $req_prep->fetch();
                // retour
                return $a;
            } catch(PDEException $e) {
                echo $e->getMessage();
            }
        }

        public function delComm($comm, $idRdv, $adresseMail) {
            $requetePreparee = "INSERT INTO Avis Values(:tag_note, :tag_comm, :tag_id, :tag_adrMail);";
		    $req_prep = Connexion::pdo()->prepare($requetePreparee);
		    // le tableau des valeurs
		    $valeurs = array(
                "tag_note" => $note,
                "tag_comm" => $comm,
                "tag_id" => $idRdv,
                "tag_adrMail" => $adresseMail
            );
		    try {
			    // envoi de la requête
			    $req_prep->execute($valeurs);
			    // traitement de la réponse
                $req_prep->setFetchmode(PDO::FETCH_CLASS,'Avis');
                // récupération de l'auteur
                $a = $req_prep->fetch();
                // retour
                return json_encode($a);
            } catch(PDEException $e) {
                echo $e->getMessage();
            }
        }
    }
?>