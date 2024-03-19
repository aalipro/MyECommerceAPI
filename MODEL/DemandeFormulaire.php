<?php
    class DemandeFormulaire extends Objet{
        protected $idDemandeProfessionnel;
        protected $valider;
        protected $nomProfessionelFormulaire;
        protected $prenomProfessionelFormulaire;
        protected $dateNaissanceProfessionelFormulaire;
        protected $specialisteFormulaire;
        protected $DescriptionFormulaire;
        protected $emailAdmin;

        protected static $objet = "DemandeFormulaire";
		protected static $cle = "idDemandeProfessionnel";
    }
?>