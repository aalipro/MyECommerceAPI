<?php
	require_once("./MODEL/FonctionUtile.php");
	
	abstract class Objet{
		protected static $objet = "Objet";
		protected static $cle = "idObjet";
		public  $type;
		public function __construct($donnees = NULL){
			$classAttributs = FonctionUtile::getAttributsOf(static::$objet);
			$this->type = static::$objet;
			if(! is_null($donnees)){
				foreach($donnees as $attribut => $valeur){
					if(in_array($attribut, $classAttributs)){
						$this->setAttribut($attribut, $valeur);
					}
					else{
						throw new Exception("$attribut n'est pas un attribut de la classe ". static::$objet);
					}
				}
			}
		}
		
		public static function checkAttributs($tabAttributs){
			$classAttributs = FonctionUtile::getAttributsOf(static::$objet);
			foreach($tabAttributs as $attribut => $valeur){
				if(in_array($attribut, $classAttributs)){
					// $this->setAttribut($attribut, $valeur);
				}
				else{
					throw new Exception("$attribut n'est pas un attribut de la classe ". static::$objet);
				}
			}
		}
		public function get($attribut){
			echo "$attribut<br>";
			return $this->$attribut;
		}
		public function setAttribut($attribut, $valeur){
			$this->$attribut = $valeur;
		}
		public function getAttribut($attribut){
			return $this->$attribut;
		}

		public static function getAllObjets(){
			$table = static::$objet;
			$requete = "SELECT * FROM " .$table;
			$resultat = Connexion::pdo()->query($requete);
			$resultat->setFetchmode(PDO::FETCH_CLASS, $table);
			// $resultat->setFetchMode(PDO::FETCH_OBJ);
			$tableau = $resultat->fetchAll();
			return $tableau;
		}

		public static function getObjetById($id) {
			$table = static::$objet;
			$cle =  static::$cle;
			$requetePreparee = "SELECT * FROM $table  WHERE $cle = :num_tag;";
			$req_prep = Connexion::pdo()->prepare($requetePreparee);

			$valeurs = array("num_tag" => $id);
			try {
				$req_prep->execute($valeurs);
				$req_prep->setFetchmode(PDO::FETCH_OBJ);
				$a = $req_prep->fetch();
				return $a? $a:null;
			} catch(PDOException $e) {
				echo $e->getMessage();
				echo "getObjetById ERROR ={$e->getMessage()}";
			}
		}
		public function save(){
			//Si l'objet est dans la BD
			$id = $this->getAttribut(static::$cle);
			//Si l'objet est dans la BD
			$objetExisteDeja = static::getObjetById($id) != null;
			if($objetExisteDeja){
				//On le met à jour
				$res = $this->update();
				$res = gettype($res);
			}
			else{
				//On l'ajoute
				$res = $this->add();
				$res = gettype($res);
			}
		}
		private function add(){
			$lesAttributs = $this->getAttributAndValue();
			return static::addObjet($lesAttributs);
		}
		private function update(){
			$lesAttributs = $this->getAttributAndValue();
			return static::updateObjet($lesAttributs);
		}

		public function getAttributAndValue(){
			$classAttributs = FonctionUtile::getAttributsOf(static::$objet);
			$lesAttributs = [];
			foreach($classAttributs as $attribut){
				$dontUse = ["type", "cle", "objet"];
				if(! in_array($attribut, $dontUse)){
					$lesAttributs[$attribut] = $this->get($attribut);
				}
			}
			static::checkAttributs($lesAttributs);
			return $lesAttributs;
		}
		public static function addObjet($lesAttributs){
			// On vérifie les 
			static::checkAttributs($lesAttributs);
            $table = static::$objet;
			$res = static::buildRequestAddObjetByArray($lesAttributs);
			$requetePreparee = $res["requete"];
			$req_prep = Connexion::pdo()->prepare($requetePreparee);
			
			$valeurs = $res["valeurs"];
			
			// try{
				$req_prep->execute($valeurs);
				return true;
			// }
			// catch(PDOException $e){
				return "ERROR\n". $e->getMessage();
				return false;
			// }s
        }
		public static function updateObjet($lesAttributs){
			static::checkAttributs($lesAttributs);
			$table = static::$objet;
			$res = static::buildResquestUpdateByArray($lesAttributs);
			$requetePreparee = $res["requete"];
			$req_prep = Connexion::pdo()->prepare($requetePreparee);
			
			$valeurs = $res["valeurs"];
			
			try{
				$req_prep->execute($valeurs);
				// echo "Update Réussi";
				return true;
			}
			catch(PDOException $e){
				// echo "<h1> ERROR= {$e->getMessage()}</h1>";
				// echo "update Raté";
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
			// echo "<h1>";
			// echo "<pre>";
			// print_r($valeurs);
			// echo "</pre>";
			// echo "<h1>$requetePrepareeFinal</h1>";
			// echo "</h1>";
			return array("requete"=>$requetePrepareeFinal,"valeurs"=>$valeurs);
		}


		public static function getObjetsByParams($attributs){
			static::checkAttributs($attributs);
			$table = static::$objet;
			$res = static::buildResquestgetByParamsByArray($attributs);
			$requetePreparee = $res["requete"];
			$req_prep = Connexion::pdo()->prepare($requetePreparee);

			$valeurs = $res["valeurs"];
			try{
				$req_prep->execute($valeurs);
				$req_prep->setFetchmode(PDO::FETCH_CLASS, $table);
				// $req_prep->setFetchmode(PDO::FETCH_OBJ);
				$a = $req_prep->fetchAll();
				return $a;
			}
			catch(PDOException $e){
				return false;
			}
		}

		public static function buildResquestgetByParamsByArray($attributs){
			$table = static::$objet;
			$cle = static::$cle;
			$requetePreparee ="SELECT * FROM $table WHERE ";
			$valeurs = array();
			foreach($attributs as $attribut => $valeur){
				// if (strpos($attribut, '%') == false) {
				// 	echo "<h1>AAAAA</h1>";
				// 	$requetePreparee =$requetePreparee."$attribut LIKE :tag_$attribut AND ";
				// }
				// else{
				// 	echo "<h1>BBBBB</h1>";
				// 	$requetePreparee =$requetePreparee."$attribut = :tag_$attribut AND ";
				// }
				$requetePreparee =$requetePreparee."$attribut = :tag_$attribut AND ";
				$valeurs["tag_$attribut"] = $valeur;
			}
			$requetePreparee = substr_replace($requetePreparee," \n" , strlen($requetePreparee)-4);

			// echo "<h1>$requetePreparee</h1>";
			return array("requete"=> $requetePreparee, "valeurs" => $valeurs);
		}

		public static function buildRequestGetByJointure($tabObjetAttribut) {

			// Vérification des paramètres
			if (!is_array($tabObjetAttribut) || empty($tabObjetAttribut)) {
				return null;
			}
			// Récupération des tableaux du paramètre
			$tableauSelect = $tabObjetAttribut['select'];
			$tabColonesAJoindre = $tabObjetAttribut['colones'];
			$tabConditionJointure = $tabObjetAttribut['conditionsJointure'];
			$tabConditions = $tabObjetAttribut['conditions'];
		
			// Construction de la requête SQL
			$requete = 'SELECT ' . implode(', ', $tableauSelect);
			$requete .= ' FROM ' . $tabColonesAJoindre[0] ."\n";
		
			// Jointures successives
			$nbJointures = count($tabColonesAJoindre);
			for ($i = 1; $i < $nbJointures; $i++) {
				$requete .= ' JOIN ' . $tabColonesAJoindre[$i] . ' ON ' . $tabConditionJointure[$i - 1]. "\n";
			}
		
			// Conditions supplémentaires
			if (!empty($tabConditions)) {
				$requete .= ' WHERE ' . implode(' AND ', $tabConditions);
			}
			return $requete;
		}
		protected static function buildResquestUpdateByArray($lesAttributs){
			$table = static::$objet;
			$cle = static::$cle;
			$valeurCle = $lesAttributs[$cle];
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
				$requetePreparee1 = $requetePreparee1. "WHERE $cle LIKE '$valeurCle'";
			else
				$requetePreparee1 = $requetePreparee1. "WHERE $cle = $valeurCle";

			return array("requete"=> $requetePreparee1, "valeurs" => $valeurs);
		}

		public function affichable(){
			return true;
		}
	}