<?php
    Class ProfessionnelSante extends Objet{
        protected $mailPro ;
        protected $mdpPro;
        protected $nomPro;
        protected $prenomPro;
        protected $dateNaissancePro;
        protected $specialitePro;
        protected $descriptionPro;
        protected $photoUrlPro;

        protected static $objet = "ProfessionnelSante";
		protected static $cle = "mailPro";
    }
?>