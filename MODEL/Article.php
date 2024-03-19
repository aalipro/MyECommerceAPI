<?php
    class Article extends Objet{
        protected $idArticle;
        protected $nomArticle;
        protected $prixArtile;
        protected $descriptionArticle;
        protected $urlImageArticle;

        protected static $objet = "Article";
        protected static $cle = "idArticle";
    }