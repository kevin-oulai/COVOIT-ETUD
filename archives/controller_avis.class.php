<?php
/**
* @file    controller_avis.class.php
* @author  Birembaux Théo

* @brief   Classe ControllerAvis s'occupe de gérer l'ouverture des vues concernant la page d'inscription
*     
*/
class ControllerAvis extends Controller{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    public function afficher(){
        echo "Afficher l'avis";
    }

    public function lister(){
        echo "lister les avis";
    }

    
}