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

        $managerLieu = new LieuDao($this->getPdo());
        $numTrajet1 = $managerLieu->findNumByVille("Anglet");
        $numTrajet2 = $managerLieu->findNumByVille("Paris");
        $listeNum1="(";
        $listeNum2="(";
        
        foreach($numTrajet1 as $num1)
        {
            $listeNum1 = $listeNum1 . $num1['numero'] . ", ";
            
        }
        $listeNum1 = substr($listeNum1, 0, -2);
        $listeNum1 = $listeNum1 . ")";
        foreach($numTrajet2 as $num2)
        {
            $listeNum2 = $listeNum2 . $num2['numero'] . ", ";
            
        }
        $listeNum2 = substr($listeNum2, 0, -2);
        $listeNum2 = $listeNum2 . ")";
        
        $managerTrajet = new TrajetDao($this->getPdo());
        $listeTrajet = $managerTrajet->findAll($listeNum1, $listeNum2, "2024-11-06", 1);

        $template = $this->getTwig()->load('pageTrajets.html.twig');

        echo $template->render(array(
            'listeTrajet' => $listeTrajet,
        ));
        
   
    }

    public function rechercher(){
        $managerEtudiant = new EtudiantDao($this->getPdo());
        $etudiant = $managerEtudiant->find(1);

        $template = $this->getTwig()->load('index.html.twig');

        echo $template->render(array(
        ));
    }

    
}