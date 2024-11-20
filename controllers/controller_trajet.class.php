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

    public function enregistrer(){
        $template = $this->getTwig()->load('proposerTrajet.html.twig');

        echo $template->render(array(
        ));

        if(isset($_POST["heureDep"]) && isset($_POST["heureArr"]) && isset($_POST["prix"]) && isset($_POST["nbPlace"]))
        {
            $heureDep = $_POST["heureDep"];
            $heureArr = $_POST["heureArr"];
            $prix = $_POST["prix"];
            $nbPlace = $_POST["nbPlace"];
            $managerTrajet = new TrajetDao($this->getPdo());
            $managerTrajet->insert($heureDep, $heureArr, $prix, $nbPlace);
            print("<p> OK </p>");
        }
        else{
            print("<p> PAS OK </p>");
        }
    }

    
}