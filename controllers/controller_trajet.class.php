<?php
include "validationAvis.php";

class ControllerTrajet extends Controller{

    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    public function afficher(){
        echo "Afficher le trajet";
    }

    public function lister(){
        $depart = $_POST['depart'];
        $arrivee = $_POST['arrivee'];
        $date = $_POST['date'];
        $nbPassager = $_POST['nombre_passagers'];
        $criteria = isset($_POST['criteria']) ? $_POST['criteria'] : '';
        if ($criteria === '') {
                $depart = $_POST['depart'];
                $_SESSION["depart"]=$depart;
                $arrivee = $_POST['arrivee'];
                $_SESSION["arrivee"]=$arrivee;
                $date = $_POST['date'];
                $_SESSION["date"]=$date;
                $nbPassager = $_POST['nombre_passagers'];
                $_SESSION["nombre_passagers"]=$nbPassager;
            } 
    }

        $managerLieu = new LieuDao($this->getPdo());
        $numTrajet1 = $managerLieu->findNumByVille($_SESSION["depart"]);
        $numTrajet2 = $managerLieu->findNumByVille($_SESSION["arrivee"]);
        if (empty($numTrajet1) || empty($numTrajet2)) {
            $template = $this->getTwig()->load('pageTrajets.html.twig');
            $infoFiltre = "aucunTrajet";
            echo $template->render(array(
                'infoFiltre' => $infoFiltre
            ));
        }
        else {
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
        //$listeTrajet = $managerTrajet->listeTrajetTrieeParHeureDep($listeNum1, $listeNum2, $date, $nbPassager);
        if ($criteria === '') {
            $listeTrajet = $managerTrajet->listeTrajetTrieeParHeureDep($listeNum1, $listeNum2, $_SESSION["date"], $_SESSION["nombre_passagers"]);
            $infoFiltre = "departTot";
        }elseif ($criteria === 'departTot') {
            $listeTrajet = $managerTrajet->listeTrajetTrieeParHeureDep($listeNum1, $listeNum2, $_SESSION["date"], $_SESSION["nombre_passagers"]);
            $infoFiltre = "departTot";
        } elseif ($criteria === 'prixBas') {
            $listeTrajet = $managerTrajet->listeTrajetTrieeParPrix($listeNum1, $listeNum2, $_SESSION["date"], $_SESSION["nombre_passagers"]);
            $infoFiltre = "PrixBas";
        }
        if (empty($listeTrajet)) {
            $infoFiltre = "aucunTrajet";
        }
        $template = $this->getTwig()->load('pageTrajets.html.twig');
        
        echo $template->render(array(
            'listeTrajet' => $listeTrajet,
            'infoFiltre' => $infoFiltre
        ));
    }
   
    }

    public function repondreOffre(){
        $id = $_GET["id"];
        $managerTrajet = new TrajetDao($this->getPdo());
        $infoTrajet = $managerTrajet->infoRepOffre($id);        

        $dateNaissance = $infoTrajet[0]['dateNaiss'];
        $aujourdhui = date("Y-m-d");
        $diff = date_diff(date_create($dateNaissance), date_create($aujourdhui));
        $age = $diff->format('%y');
        $template = $this->getTwig()->load('repondreOffreTrajet.html.twig');
        echo $template->render(array(
            'infoTrajet' => $infoTrajet,
            'age' => $age
        ));
    }

    public function listerParticipations(){
        $numero_etudiant = $_SESSION['id'];

        $managerTrajet = new TrajetDao($this->getPdo());
        $listeTrajets = $managerTrajet->findAllByPassager($numero_etudiant);

        $managerLieu = new LieuDao($this->getPdo());
        $listeLieux = $managerLieu->findAllAssoc();

        $managerEtudiant = new EtudiantDao($this->getPdo());
        $listeEtudiants = $managerEtudiant->findAllAssoc();
        $twigparams = array('listeTrajets' => $listeTrajets, 'lieux' => $listeLieux, 'etudiants' => $listeEtudiants);
        if(isset($listeErreurs)){
            $twigparams['listeErreurs'] = $listeErreurs;
        }
        $template = $this->getTwig()->load('mesParticipations.html.twig');
        echo $template->render($twigparams);

        if(isset($_GET['action'])){
            if($_GET['action'] == "poster"){
                $listeErreurs = [];
                if(validerCommentaire($_POST['message'],$listeErreurs) && validerNote($_POST['note'], $listeErreurs)) {
                    $concerne = $managerTrajet->getConducteur($_GET['id']);
                    $commentateur = $_SESSION['id'];
                    $datePost = date("Y-m-d h:i:s");
                    $managerAvis = new AvisDao($this->getPdo());
                    $managerAvis->insert($datePost, $_POST['message'], $_POST['note'], $concerne, $commentateur);
                    echo "<div id=modalTrigger></div>";
                }
                else{
                    echo "<div class=\"modal fade\" id=errorModal tabindex=-1 role=dialog aria-labelledby=exampleModalLabel aria-hidden=true style=\"backdrop-filter: blur(2px)\">
                            <div class=\"modal-dialog modal-dialog-centered\" role=document>
                                <div class=\"modal-content bg-gradient-danger border-2\">
                                <div class='modal-title ms-3 mt-4'>Attention !</div>
                                <hr>
                                    <div class=modal-body>
                                        <p>Erreurs :</p>
                                        <ul>";
                                            foreach($listeErreurs as $erreur){
                                                echo "<li>$erreur</li>";
                                            }
                                        echo "</ul>
                                    </div>
                                    <div class=modal-footer>
                                        <button type=button class='btn btn-primary' onclick=\"location = 'index.php?controleur=trajet&methode=listerParticipations';\">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id=errorModalTrigger></div>";
                                            
                }
            }
        }
    }

    public function listerMesTrajets(){
        $template = $this->getTwig()->load('mesTrajets.html.twig');
        $managerTrajet = new TrajetDao($this->getPdo());
        $managerLieu = new LieuDao($this->getPdo());

        $lieux = $managerLieu->findAllAssoc();

        $listeMesTrajets = $managerTrajet->findAllByConducteur($_SESSION["id"]);
        $listeDesReservations = $managerTrajet->getAllNombreReservations();
        echo $template->render(array(
            "listeTrajets" => $listeMesTrajets,
            "lieux" => $lieux,
            "listeReservations" => $listeDesReservations
        ));

        if(isset($_GET['action'])){
            if($_GET['action'] == "supprimer"){
                $managerTrajet->delete($_GET['id']);
                echo "<div id=modalTriggerSuppr></div>";
            }
            elseif ($_GET['action'] == "modifier"){

                $lieuDepart = $_POST["lieu_depart"];
                $lieuArrivee = $_POST["lieu_arrivee"];

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

                $managerTrajet->update($_GET['id'],$_POST['heureDep'], $_POST['heureArr'], $_POST['prix'], $_POST['dateDep'], $numero_lieu_depart, $numero_lieu_arrivee);

                echo "<div id=modalTriggerModif></div>";
            }
        }
    }

    public function rechercher(){

        $template = $this->getTwig()->load('index.html.twig');
        echo $template->render(array(
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
                $numero_conducteur = $_SESSION['id']; // A changer lorsque les variables de session serons mises en place.
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