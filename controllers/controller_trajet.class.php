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
            // On initialise les managers qui nous serons utiles
            $managerLieu = new LieuDao($this->getPdo());
            $managerTrajet = new TrajetDao($this->getPdo());

            // On récupère toutes les variables nécessaires à l'insertion d'un trajet
            $numero_conducteur = 1; // A changer lorsque les variables de session serons mises en place.
            $heureDep = $_POST["heureDep"];
            $heureArr = $_POST["heureArr"];
            $prix = $_POST["prix"];
            $nbPlace = $_POST["nbPlace"];
            $lieuDepart = $_POST["lieuDepart"];
            $lieuArrivee = $_POST["lieuArrivee"];

            // On explose la chaine de carateres en se basant sur les espaces
            // pour récupérer ensuite séparément le numéro de rue, le nom de rue et la ville
            $expLieuDepart = explode(" ", $lieuDepart);
            $expLieuArrivee = explode(" ", $lieuArrivee);

            // On récupere le numéro de rue qui est le premier élément de la liste explosée de l'adresse
            $numRueDep = $expLieuDepart[0];
            $numRueArr= $expLieuArrivee[0];

            // On récupere la ville qui est le dernier élément de la liste explosée de l'adresse
            $villeDep = $expLieuDepart[sizeof($expLieuDepart)-1];
            $villeArr = $expLieuArrivee[sizeof($expLieuArrivee)-1];

            //Initialisation des noms de rue
            $nomRueDep = "";
            $nomRueArr = "";

            // On parcours et concatene toutes les parties de l'adresse sauf le numéro de rue et la ville pour avoir uniquement le nom de rue
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

            // On retire une virgule parasite
            $nomRueDep = substr($nomRueDep, 0, strlen($nomRueDep)-2);
            $nomRueArr = substr($nomRueArr, 0, strlen($nomRueArr)-2);

            // On regarde si le lieu de départ existe, si ce n'est pas le cas on l'insere dans la bd
            if(!$managerLieu->existe($numRueDep, $nomRueDep, $villeDep)){
                $managerLieu->insert($numRueDep, $nomRueDep, $villeDep);
            }

            // On regarde si le lieu d'arrivée existe, si ce n'est pas le cas on l'insere dans la bd
            if(!$managerLieu->existe($numRueArr, $nomRueArr, $villeArr)){
                $managerLieu->insert($numRueArr, $nomRueArr, $villeArr);
            }

            // Récupération des numéros de trajet à partir des autres colonnes
            $numero_lieu_depart = $managerLieu->findNum($numRueDep, $nomRueDep, $villeDep);
            $numero_lieu_arrivee = $managerLieu->findNum($numRueArr, $nomRueArr, $villeArr);

            // Insertion du trajet dans la BD
            $managerTrajet->insert($heureDep, $heureArr, $prix, $nbPlace, $numero_conducteur, $numero_lieu_depart, $numero_lieu_arrivee);

            echo "<div id=modalTrigger></div>";
        }
    }
}