<?php
    Class Avis extends Objet{
        protected $idAvis;
        protected $note;
        protected $commentaire;
        protected $idRdv;
        protected $adresseMail;

        protected static $objet = "Avis";
		protected static $cle = "idAvis";
    }
?>