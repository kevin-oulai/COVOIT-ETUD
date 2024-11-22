<?php

class ControllerTrajet extends Controller{

    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    public function afficher(){
        echo "Afficher le trajet";
    }

    public function lister(){
        echo "lister les trajets";
    }

    public function rechercher(){
        $managerEtudiant = new EtudiantDao($this->getPdo());
        $etudiant = $managerEtudiant->find(1);
        //var_dump($etudiant);

        $template = $this->getTwig()->load('index.html.twig');

        echo $template->render(array(
        ));
    }

    
}