<?php

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