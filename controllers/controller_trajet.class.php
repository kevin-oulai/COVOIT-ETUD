<?php
/**
* @file    controller_trajet.class.php
* @author  Galles Titouan

* @brief   Classe ControllerTrajet s'occupe de gérer l'ouverture des vues concernant les pages de trajet
*     
*/
class ControllerTrajet extends Controller{
        /**
     * @brief Permet de créer l'instance du controller
     *
     * @param Twig\Environment $twig
     * @param Twig\Loader\FilesystemLoader $loader
     */
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    /**
     * @brief permet d'afficher la page qui liste les trajets d'une recherche
     *
     * @return void
     */
    public function lister(){
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
            'nbPassager' => $nbPassager,
            'listeTrajet' => $listeTrajet,
            'infoFiltre' => $infoFiltre
        ));
    }
   
    }
    /**
     * @brief permet d'afficher et gerer la page repondre à une offre 
     *
     * @return void
     */
    public function repondreOffre(){
        // On récupère l'id du trajet
        $id = $_GET["id"];
        $managerTrajet = new TrajetDao($this->getPdo());
        $infoTrajet = $managerTrajet->infoRepOffre($id); 

        // On récupère le nombre de passagers qui veulent prendre un trajet
        $nbPassager=$_SESSION["nombre_passagers"];
        
        // Calcul de l'age
        $dateNaissance = $infoTrajet[0]['dateNaiss'];
        $aujourdhui = date("Y-m-d");
        $diff = date_diff(date_create($dateNaissance), date_create($aujourdhui));
        $age = $diff->format('%y');

        // On affiche la page de réponse à l'offre
        $template = $this->getTwig()->load('repondreOffreTrajet.html.twig');
        echo $template->render(array(
            'nbPassager' => $nbPassager,
            'infoTrajet' => $infoTrajet,
            'age' => $age
        ));
    }
    /**
     * @brief permet d'afficher la page qui affiche les participations d'un utilisateur
     *
     * @return void
     */
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
    /**
     * @brief permet d'afficher la page qui liste les trajets créés par l'utilisateur
     *
     * @return void
     */
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
            elseif ($_GET['action'] == "modifier") {
                $listeErreurs = array();
                if (validationPlageHoraire($_POST["heureDep"], $_POST["heureArr"], date("Y-m-d", strtotime($_POST['dateDep'])), $listeErreurs) && validationPrix($_POST["prix"], $listeErreurs) && validationLieuDepart($_POST["lieu_depart"], $listeErreurs) && validationLieuArrivee($_POST["lieu_arrivee"], $listeErreurs) && validationDateDep(date("Y-m-d", strtotime($_POST['dateDep'])), $listeErreurs)) {

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

                    $managerTrajet->update($_GET['id'], $_POST['heureDep'], $_POST['heureArr'], $_POST['prix'], $_POST['dateDep'], $numero_lieu_depart, $numero_lieu_arrivee);

                    echo "<div id=modalTriggerModif></div>";
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
                                            <button type=button class='btn btn-primary' onclick=\"location = 'index.php?controleur=trajet&methode=listerMesTrajets';\">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id=errorModalTrigger></div>";

                }
            }
        }
    }
    /**
     * @brief permet d'afficher la page d'accueil pour rechercher un trajet
     *
     * @return void
     */
    public function rechercher(){

        $template = $this->getTwig()->load('index.html.twig');
        echo $template->render(array(
        ));
    }
    /**
     * @brief afficher la page qui permet d'enregistrer un trajet 
     *
     * @return void
     */
    public function enregistrer()
    {
        if (isset($_SESSION['login']) || isset($_SESSION['pwd'])) {
            $template = $this->getTwig()->load('proposerTrajet.html.twig');
            $listeErreurs = array();

            echo $template->render(array());

            if(isset($_GET['action'])){
                if($_GET['action'] == "enregistrer"){

                    // On initialise les managers qui nous serons utiles
                    $managerLieu = new LieuDao($this->getPdo());
                    $managerTrajet = new TrajetDao($this->getPdo());

                    $numero_conducteur = $_SESSION['id'];
                    if(validationPlageHoraire($_POST["heureDep"], $_POST["heureArr"],date("Y-m-d", strtotime($_POST['dateDep'] )), $listeErreurs) && validationPrix($_POST["prix"], $listeErreurs) && validationNbPlaces($_POST["nbPlace"], $listeErreurs) && validationLieuDepart($_POST["lieuDepart"], $listeErreurs) && validationLieuArrivee($_POST["lieuArrivee"], $listeErreurs) && validationDateDep(date("Y-m-d", strtotime($_POST['dateDep'] )), $listeErreurs)){

                        // On récupère toutes les variables nécessaires à l'insertion d'un trajet
                        $heureDep = $_POST["heureDep"];
                        $heureArr = $_POST["heureArr"];
                        $prix = $_POST["prix"];
                        $nbPlace = $_POST["nbPlace"];
                        $lieuDepart = $_POST["lieuDepart"];
                        $lieuArrivee = $_POST["lieuArrivee"];
                        $dateDep = date("Y-m-d", strtotime($_POST['dateDep']));

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
                        $managerTrajet->insert($heureDep, $heureArr, $prix,$dateDep, $nbPlace, $numero_conducteur, $numero_lieu_depart, $numero_lieu_arrivee);

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
                                            <button type=button class='btn btn-primary' onclick=\"location = 'index.php?controleur=trajet&methode=enregistrer';\">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id=errorModalTrigger></div>";

                    }
                }
            }
        }

        else{
            echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        }
    }
}