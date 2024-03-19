<?php
    Class Client extends Objet{
        protected $mailClient;
        protected $mdpClient;
        protected $nomClient;
        protected $pseudoClient;
        protected $prenomClient;
        protected $dateNaissanceClient;
        protected $adresseCompleteClient;
        protected $telephoneClient;
        
        protected static $objet = "Client";
		protected static $cle = "mailClient";

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