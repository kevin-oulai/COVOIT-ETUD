<?php

class ControllerTrajet extends Controller{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    public function afficher(){
        echo "Afficher le trajet";
    }

    public function lister(){
        // $depart = $_POST['depart'];
        // $arrivee = $_POST['arrivee'];
        // $date = $_POST['date'];
        // $nbPassager = $_POST['nombre_passagers'];

        $managerTrajet = new LieuDao($this->getPdo());
        $numTrajet1 = $managerTrajet->findNumByVille("Anglet");
        $numTrajet2 = $managerTrajet->findNumByVille("Paris");
        var_dump($numTrajet1);
        var_dump($numTrajet2);

        $template = $this->getTwig()->load('pageTrajets.html.twig');

        echo $template->render(array(
        ));
        
   
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