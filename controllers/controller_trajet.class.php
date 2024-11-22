<?php

session_start();

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
            $managerLieu = new LieuDao($this->getPdo());
//            $numero_conducteur =  $_SESSION["id"];
            $numero_conducteur = 1;
            $heureDep = $_POST["heureDep"];
            $heureArr = $_POST["heureArr"];
            $prix = $_POST["prix"];
            $nbPlace = $_POST["nbPlace"];
            $lieuDepart = $_POST["lieuDepart"];
            $lieuArrivee = $_POST["lieuArrivee"];
            $expLieuDepart = explode(" ", $lieuDepart);
            $expLieuArrivee = explode(" ", $lieuArrivee);
            $numRueDep = $expLieuDepart[0];
            $numRueArr= $expLieuArrivee[0];
            $villeDep = $expLieuDepart[sizeof($expLieuDepart)-1];
            $villeArr = $expLieuArrivee[sizeof($expLieuArrivee)-1];
            $nomRueDep = "";
            $nomRueArr = "";
            foreach ($expLieuDepart as $part) {
                if($part != $numRueDep && $part != $villeDep && $part){
                    $nomRueDep .= $part . " ";
                }
            }
            foreach ($expLieuArrivee as $part) {
                if($part != $numRueArr && $part != $villeArr){
                    $nomRueArr .= $part . " ";
                }
            }
            $nomRueDep = substr($nomRueDep, 0, strlen($nomRueDep)-2);
            $nomRueArr = substr($nomRueArr, 0, strlen($nomRueArr)-2);
            // On regarde si le lieu existe, si ce n'est pas le cas on l'insere dans la bd
            if(!$managerLieu->existe($numRueDep, $nomRueDep, $villeDep)){
                $managerLieu->insert($numRueDep, $nomRueDep, $villeDep);
            }

            if(!$managerLieu->existe($numRueArr, $nomRueArr, $villeArr)){
                $managerLieu->insert($numRueArr, $nomRueArr, $villeArr);
            }

            $numero_lieu_depart = $managerLieu->findNum($numRueDep, $nomRueDep, $villeDep);
            $numero_lieu_arrivee = $managerLieu->findNum($numRueArr, $nomRueArr, $villeArr);

            echo $numero_lieu_depart . "<br>";
            echo $numero_lieu_arrivee . "<br>";

            $managerTrajet = new TrajetDao($this->getPdo());
            //$managerTrajet->insert($heureDep, $heureArr, $prix, $nbPlace, $numero_conducteur);
        }
    }
}