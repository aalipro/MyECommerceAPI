<?php
    Class RendezVous extends Objet{
        protected $idRdv;
        protected $heureDebut;
        protected $heureFin;
        protected $dateRdv;
        protected $natureDemande;
        protected $idPersonnelAdministratif;
        protected $idProfessionnelSante;
        protected $adresseMail;

        protected static $objet = "RendezVous";
		protected static $cle = "idRdv";
    }
?>