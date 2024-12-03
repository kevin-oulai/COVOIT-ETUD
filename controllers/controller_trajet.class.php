<?php

class ControllerTrajet extends Controller{

    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    public function afficher(){
        echo "Afficher le trajet";
    }

    public function lister(){


        $criteria = isset($_POST['criteria']) ? $_POST['criteria'] : '';
        echo $criteria;
        if ($criteria === '') {
                echo "On vient d'arriver sur la page";
                $depart = $_POST['depart'];
                $_SESSION["depart"]=$depart;
                $arrivee = $_POST['arrivee'];
                $_SESSION["arrivee"]=$arrivee;
                $date = $_POST['date'];
                $_SESSION["date"]=$date;
                $nbPassager = $_POST['nombre_passagers'];
                $_SESSION["nombre_passagers"]=$nbPassager;
            } 

        $managerLieu = new LieuDao($this->getPdo());
        $numTrajet1 = $managerLieu->findNumByVille($_SESSION["depart"]);
        $numTrajet2 = $managerLieu->findNumByVille($_SESSION["arrivee"]);
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
        $listeTrajet = $managerTrajet->findAll($listeNum1, $listeNum2, $date, $nbPassager);

        if ($criteria === 'departTot') {
            // Option "Départ le plus tôt"
            echo "Vous avez sélectionné : Départ le plus tôt.";
            // Placez ici la logique spécifique pour cette option
        } elseif ($criteria === 'prixBas') {
            // Option "Prix le plus bas"
            echo "Vous avez sélectionné : Prix le plus bas.";
            // Placez ici la logique spécifique pour cette option
        } else {
            // Si une valeur inattendue est envoyée (par exemple, une manipulation)
            echo "Option non valide.";
        }

        $template = $this->getTwig()->load('pageTrajets.html.twig');

        echo $template->render(array(
            'listeTrajet' => $listeTrajet,
        ));
        
   
    }

    public function rechercher(){
        $managerEtudiant = new EtudiantDao($this->getPdo());
        $etudiant = $managerEtudiant->find(1);

        $connected = false;
        $conducteur = false;

        if (isset($_SESSION['login']) || isset($_SESSION['pwd'])) {
            $connected = true;
            if ($_SESSION['voiture'] != null){
                $conducteur = true;
            }
        }

        $template = $this->getTwig()->load('index.html.twig');
        echo $template->render(array(
            'conducteur' => $conducteur,
            'connected' => $connected
        ));
    }

    public function enregistrer()
    {
        if (isset($_SESSION['login']) || isset($_SESSION['pwd'])) {
            $template = $this->getTwig()->load('proposerTrajet.html.twig');

            echo $template->render(array());

            if (isset($_POST["heureDep"]) && isset($_POST["heureArr"]) && isset($_POST["prix"]) && isset($_POST["nbPlace"])) {
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
                $numRueArr = $expLieuArrivee[0];

                // On récupere la ville qui est le dernier élément de la liste explosée de l'adresse
                $villeDep = $expLieuDepart[sizeof($expLieuDepart) - 1];
                $villeArr = $expLieuArrivee[sizeof($expLieuArrivee) - 1];

                //Initialisation des noms de rue
                $nomRueDep = "";
                $nomRueArr = "";

                // On parcours et concatene toutes les parties de l'adresse sauf le numéro de rue et la ville pour avoir uniquement le nom de rue
                foreach ($expLieuDepart as $part) {
                    if ($part != $numRueDep && $part != $villeDep && $part) {
                        $nomRueDep .= $part . " ";
                    }
                }
                foreach ($expLieuArrivee as $part) {
                    if ($part != $numRueArr && $part != $villeArr) {
                        $nomRueArr .= $part . " ";
                    }
                }

                // On retire une virgule parasite
                $nomRueDep = substr($nomRueDep, 0, strlen($nomRueDep) - 2);
                $nomRueArr = substr($nomRueArr, 0, strlen($nomRueArr) - 2);

                // On regarde si le lieu de départ existe, si ce n'est pas le cas on l'insere dans la bd
                if (!$managerLieu->existe($numRueDep, $nomRueDep, $villeDep)) {
                    $managerLieu->insert($numRueDep, $nomRueDep, $villeDep);
                }

                // On regarde si le lieu d'arrivée existe, si ce n'est pas le cas on l'insere dans la bd
                if (!$managerLieu->existe($numRueArr, $nomRueArr, $villeArr)) {
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
        else{
            echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        }
    }
}