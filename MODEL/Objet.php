<?php
	abstract class Objet{
		protected static $objet = "Objet";
		protected static $cle = "idObjet";
		/*
		public function __construct($donnees = NULL){
			if(!is_null($donnees){
				foreach($donnees as $attribut : $valeur){
					$this->set($attribut, $valeur);
				}
			}
		}
		*/
		public function get($attribut){
			return $this->$attribut;
		}
		
		public function setAttribut($attribut, $valeur){
			$this->$attribut = $valeur;
		}

		
		public static function getAllObjets(){
			$table = static::$objet;
			// echo "<p> table=$table</p>";
			$requete = "SELECT * FROM " .$table;
			$resultat = Connexion::pdo()->query($requete);
			$resultat->setFetchmode(PDO::FETCH_CLASS, $table);
			$tableau = $resultat->fetchAll();
			return $tableau;
		}

		public static function getObjetById($id) {
			$table = static::$objet;
			$cle =  static::$cle;
			$requetePreparee = "SELECT * FROM $table NATURAL JOIN WHERE $cle = :num_tag;";
			// echo "<h1>$requetePreparee</h1>";
			$req_prep = Connexion::pdo()->prepare($requetePreparee);
			$valeurs = array("num_tag" => $id);
			try {
				$req_prep->execute($valeurs);
			$req_prep->setFetchmode(PDO::FETCH_CLASS,$table);
				$a = $req_prep->fetch();
				return $a;
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		}

		public static function addObjet($lesAttributs){
            $table = static::$objet;
			$res = static::buildRequestAddObjetByArray($lesAttributs);
			$requetePreparee = $res["requete"];
			$req_prep = Connexion::pdo()->prepare($requetePreparee);
			
			$valeurs = $res["valeurs"];
			
			try{
				$req_prep->execute($valeurs);
				return true;
			}
			catch(PDOException $e){
				return false;
			}
        }

		public static function deleteObjetById($id){
			$table = static::$objet;
			$cle = static::$cle;
			if(gettype($id) == 'string'){
				$requetePreparee = "DELETE FROM `$table` WHERE $cle = :tag_$cle";
			}
			else{
				$requetePreparee = "DELETE FROM `$table` WHERE $cle LIKE ':tag_$cle'";
			} 
			$valeurs = array("tag_$cle" => $id);
			$req_prep = Connexion::pdo()->prepare($requetePreparee);
			try{
				$req_prep->execute($valeurs);
				return true;
			}
			catch(PDOException $e){
				return false;
			}
		}

		protected static function buildRequestAddObjetByArray($lesAttributs){
			$table = static::$objet;
            $requetePreparee1 = "INSERT INTO $table(";//;(nom,prenom,anneeNaissance) VALUES(:n_tag,:p_tag,:a_tag);";
            $requetePreparee2 = "VALUES(";
			$valeurs = array();
			foreach($lesAttributs as $attribut=> $valeur){
                $requetePreparee1 = $requetePreparee1."`$attribut`,";
				$requetePreparee2 = $requetePreparee2.":tag_$attribut,";
				$valeurs[":tag_$attribut"] = $valeur;
			}
			$requetePreparee1 = substr_replace($requetePreparee1,")" , strlen($requetePreparee1)-1);
			$requetePreparee2 = substr_replace($requetePreparee2,")" , strlen($requetePreparee2)-1);
			
			$requetePrepareeFinal = $requetePreparee1 ." " . $requetePreparee2;
			echo "<h1>";
			echo "<pre>";
			print_r($valeurs);
			echo "</pre>";
			echo "<h1>$requetePrepareeFinal</h1>";
			echo "</h1>";
			return array("requete"=>$requetePrepareeFinal,"valeurs"=>$valeurs);
		}

		public static function updateObjet($lesAttributs){
			$table = static::$objet;
			echo "<pre>";
			print_r($lesAttributs);
			echo "</pre>";
			$res = static::buildResquestUpdateByArray($lesAttributs);
			$requetePreparee = $res["requete"];
			$req_prep = Connexion::pdo()->prepare($requetePreparee);
			
			$valeurs = $res["valeurs"];
			
			try{
				$req_prep->execute($valeurs);
				return true;
			}
			catch(PDOException $e){
				return false;
			}
		}

		public static function getObjetByParams($attribut){
			//attribut dictionnaire avec : mail et mdp
			$table = static::$objet;
			$res = buildResquestgetByParamsByArray($attribut);
			$requetePreparee = $res["requete"];

			$req_prep = Connexion::pdo()->prepare($requetePreparee);

			$valeurs = $res["valeurs"];
			try{
				$req_prep->execute($valeurs);
				$req_prep->setFetchmode(PDO::FETCH_CLASS,$table);
				$a = $req_prep->fetch();
				return $a;
			}
			catch(PDOException $e){
				return false;
			}
		}

		public static function buildResquestgetByParamsByArray($attribut){
			$table = static::$objet;
			$cle = static::$cle;
			$requetePreparee ="SELECT * FROM $table WHERE ";
			$valeurs = array();
			foreach($attribut as $attribut => $valeur){
				$requetePreparee += ":tag_$attribut = $valeur AND ";
				$valeurs["tag_$attribut"] = $valeur;
			}
			$requetePreparee = substr_replace($requetePreparee1," \n" , strlen($requetePreparee1)-4);
			return return array("requete"=> $requetePreparee, "valeurs" => $valeurs);
		}

		protected static function buildResquestUpdateByArray($lesAttributs){
			$table = static::$objet;
			$cle = static::$cle;
			$valeurCle = $lesAttributs[$cle];
			echo "<pre>";
			print_r($lesAttributs);
			echo "</pre>";
			$requetePreparee1 = "UPDATE $table \n SET ";
			$valeurs = array();
			foreach($lesAttributs as $attribut => $valeur){
				if($attribut != $cle){
					$requetePreparee1 = $requetePreparee1 . "$attribut = :tag_$attribut,\n";
					$valeurs["tag_$attribut"] = $valeur;
				}
			}
			$requetePreparee1 = substr_replace($requetePreparee1," \n" , strlen($requetePreparee1)-2);

			if(gettype($valeurCle) =='string')
				$requetePreparee1 = $requetePreparee1. "WHERE $cle = '$valeurCle'";
			else
				$requetePreparee1 = $requetePreparee1. "WHERE $cle = $valeurCle";

			echo "<h1>$requetePreparee1 <h1>";
			return array("requete"=> $requetePreparee1, "valeurs" => $valeurs);
		}

		public function affichable(){
			return true;
		}
	}
?>