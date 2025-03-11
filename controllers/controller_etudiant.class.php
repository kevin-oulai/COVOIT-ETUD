<?php
/**
 * @file    controller_etudiant.class.php
 * @author  Theo BIREMBAUX, Kevin OULAI

 * @brief Classe ControllerEtudiant traite les informations envoyées et gére l'ouverture des vues concernant les étudiants
 *
 * @details Cette classe permet de traiter les actions de l'utilisateur, modifier les données des modèles et des vues
 *
 * @version 0.1
 * @date    11/01/2025
 */

class ControllerEtudiant extends Controller{
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
     * @brief Affiche la page de profil d'un utilisateur
     *
     * @return void
     */
    public function afficher(){
        $this->verifierConnexion();
        $num_etudiant = $_GET['id'];
        $managerEtudiant = new EtudiantDao($this->getPdo());
        $etudiant = $managerEtudiant->find($num_etudiant);
        $twig_params = array('etudiant' => $etudiant);
        // var_dump($_SESSION);

        if($managerEtudiant->possedeBadge($num_etudiant)) { // Verifier si l'étudiant possède des badges
            $managerBadge = new BadgeDao($this->getPdo());
            $listeBadge = $managerBadge->findAll($num_etudiant);
            $twig_params['listeBadge'] = $listeBadge;
        }

        $managerVoiture = new VoitureDao($this->getPdo());
        if($_SESSION['CLIENT']->getNumeroVoiture() != null) { // Verifier si l'étudiant est un conducteur
            $managerNbTrajet = new EtudiantDao($this->getPdo());
            $nbTrajet = $managerNbTrajet->findNbTrajets($num_etudiant);
            $voiture = $managerVoiture->findByEtudiant($num_etudiant);
            $twig_params['nbTrajet'] = $nbTrajet;
            $twig_params['voiture'] = $voiture;
        }

        // Dans etudiant verifier que l'étudiant a posté un avis.
        if($managerEtudiant->aPosteAvis($num_etudiant)) {
            $managerAvisDonnes = new AvisDao($this->getPdo());
            $managerEtudiantConcerne = new EtudiantDao($this->getPdo());
            $listeAvisDonnes = $managerAvisDonnes->findAllCommentateur($num_etudiant);
            $twig_params['listeAvisDonnes'] = $listeAvisDonnes;
        }

        if($managerEtudiant->aRecuAvis($num_etudiant)) {
            $managerAvisReçus = new AvisDao($this->getPdo());
            $managerEtudiantCommentateur = new EtudiantDao($this->getPdo());
            $listeAvisReçus = $managerAvisReçus->findAllConcerne($num_etudiant);
            $twig_params['listeAvisReçus'] = $listeAvisReçus;
        }
        
        if(isset($_GET['action'])){
            $numero_voiture = NULL;
            if($_GET['action'] == "modifier"){
                if($_POST['modele'] != '' && $_POST['marque'] != '' && $_POST['nbPlace'] != ''){
                    $modele = $_POST['modele'];
                    $marque = $_POST['marque'];
                    $nbPlace = $_POST['nbPlace'];
                    
                    // On regarde si la voiture de départ existe, si ce n'est pas le cas on l'insere dans la bd
                    if (!$managerVoiture->existe($modele, $marque, $nbPlace)) {
                        $managerVoiture->insert($modele, $marque, $nbPlace);
                    }
                    
                    // Récupération du numéro de voiture à partir des autres colonnes
                    $numero_voiture = $managerVoiture->findNum($modele, $marque, $nbPlace);
                }

                $messagesErreurs = [];

                validerNom($_POST['nom'], $messagesErreurs);
                validerPrenom($_POST['prenom'], $messagesErreurs);
                validerDateDeNaissance($_POST['dateNaiss'], $messagesErreurs);
                validerTelephone($_POST['tel'], $messagesErreurs);
                validerMailProfil($_POST['mail'], $messagesErreurs);

                if (!is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    $nomPhoto = $etudiant->getPhotoProfil();
                }
                else {
                    validerUploadEtPdp($_FILES["image"], $messagesErreurs);
                    $photoProfil = $_FILES["image"]["tmp_name"];

                    if (empty($messagesErreurs)) {
                        $dir = "images"; // Nom du dossier contenant les photos
                        $nomPhoto = rand(0, 2147483647) . ".png";
                        move_uploaded_file($photoProfil, "$dir/$nomPhoto");
                    }
                }

                if (!empty($messagesErreurs)) {
                    $template = $this->getTwig()->load('profil.html.twig');
                    
                    $twig_params['erreurs'] = $messagesErreurs;
                    $twig_params['etudiant'] = $etudiant;

                } else {
                    $updated = new Etudiant($num_etudiant, $_POST['nom'], $_POST['prenom'], $_POST['dateNaiss'], $_POST['mail'], $_POST['tel'], $numero_voiture, $nomPhoto);
                    $_SESSION['CLIENT'] = $updated;
                    $managerEtudiant->update($num_etudiant, $_POST['nom'], $_POST['prenom'], $_POST['dateNaiss'], $_POST['mail'], $_POST['tel'], $numero_voiture, $nomPhoto);
                    echo "<div id=modalTriggerModif></div>";
                }
            }
        }
        $template = $this->getTwig()->load('profil.html.twig');                
        echo $template->render($twig_params);
    }    
}