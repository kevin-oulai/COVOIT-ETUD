<?php

class ControllerEtudiant extends Controller{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    public function afficher(){
        $num_etudiant = $_SESSION['id'];
        $managerEtudiant = new EtudiantDao($this->getPdo());
        $etudiant = $managerEtudiant->find($num_etudiant);
        $twig_params = array('etudiant' => $etudiant);

        if($managerEtudiant->possedeBadge($num_etudiant)) { // Verifier si l'étudiant possède des badges
            $managerBadge = new BadgeDao($this->getPdo());
            $listeBadge = $managerBadge->findAll($num_etudiant);
            $twig_params['listeBadge'] = $listeBadge;
        }

        $managerVoiture = new VoitureDao($this->getPdo());
        if($managerEtudiant->estConducteur($num_etudiant)) { // Verifier si l'étudiant est un conducteur
            $managerNbTrajet = new EtudiantDao($this->getPdo());
            $nbTrajet = $managerNbTrajet->findNbTrajets($num_etudiant);
            $voiture = $managerVoiture->findMonEtudiant($num_etudiant);
            $twig_params['nbTrajet'] = $nbTrajet;
            $twig_params['voiture'] = $voiture;
        }

        // Dans etudiant verifier que l'étudiant a posté un avis.
        if($managerEtudiant->aPosteAvis($num_etudiant)) {
            $managerAvisDonnes = new AvisDao($this->getPdo());
            $managerEtudiantConcerne = new EtudiantDao($this->getPdo());
            $etudiantConcerne = $managerEtudiantConcerne->findConcerneParAvis($num_etudiant);
            $listeAvisDonnes = $managerAvisDonnes->findAllCommentateur($num_etudiant);
            $twig_params['listeAvisDonnes'] = $listeAvisDonnes;
            $twig_params['etudiantConcerne'] = $etudiantConcerne;
        }

        if($managerEtudiant->aRecuAvis($num_etudiant)) {
            $managerAvisReçus = new AvisDao($this->getPdo());
            $managerEtudiantCommentateur = new EtudiantDao($this->getPdo());
            $etudiantCommentateur = $managerEtudiantCommentateur->findCommentateurDAvis($num_etudiant);
            $listeAvisReçus = $managerAvisReçus->findAllConcerne($num_etudiant);
            $twig_params['listeAvisReçus'] = $listeAvisReçus;
            $twig_params['etudiantCommentateur'] = $etudiantCommentateur;
        }

        $template = $this->getTwig()->load('profil.html.twig');

        echo $template->render($twig_params);

        if(isset($_GET['action'])){
            if($_GET['action'] == "modifier"){
                $numero_voiture = NULL;
                if($_POST['modele'] != '' && $_POST['marque'] != '' && $_POST['nbPlace'] != ''){
                    $modele = $_POST['modele'];
                    $marque = $_POST['marque'];
                    $nbPlace = $_POST['nbPlace'];

                    var_dump($_POST);
                    // On regarde si la voiture de départ existe, si ce n'est pas le cas on l'insere dans la bd
                    if (!$managerVoiture->existe($modele, $marque, $nbPlace)) {
                        $managerVoiture->insert($modele, $marque, $nbPlace);
                    }

                    // Récupération du numéro de voiture à partir des autres colonnes
                    $numero_voiture = $managerVoiture->findNum($modele, $marque, $nbPlace);
                }
                $managerEtudiant->update($_GET['id'],$_POST['nom'], $_POST['prenom'], $_POST['dateNaiss'], $_POST['adresseMail'], $_POST['numTelephone'], $numero_voiture, $_POST['photoProfil']);

                echo "<div id=modalTriggerModif></div>";
            }
        }

    }
    
}