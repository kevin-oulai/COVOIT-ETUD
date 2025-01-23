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
        $num_etudiant = $_GET['id'];
        $managerEtudiant = new EtudiantDao($this->getPdo());
        $etudiant = $managerEtudiant->find($num_etudiant);
        $twig_params = array('etudiant' => $etudiant);

        if($managerEtudiant->possedeBadge($num_etudiant)) { // Verifier si l'étudiant possède des badges
            $managerBadge = new BadgeDao($this->getPdo());
            $listeBadge = $managerBadge->findAll($num_etudiant);
            $twig_params['listeBadge'] = $listeBadge;
        }

        $managerVoiture = new VoitureDao($this->getPdo());
        if($GLOBALS['CONDUCTEUR'] == 'true') { // Verifier si l'étudiant est un conducteur
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
            $listeAvisDonnes = $managerAvisDonnes->findAllCommentateur($num_etudiant);
            $twig_params['listeAvisDonnes'] = $listeAvisDonnes;
        }

        if($managerEtudiant->aRecuAvis($num_etudiant)) {
            $managerAvisReçus = new AvisDao($this->getPdo());
            $managerEtudiantCommentateur = new EtudiantDao($this->getPdo());
            $listeAvisReçus = $managerAvisReçus->findAllConcerne($num_etudiant);
            $twig_params['listeAvisReçus'] = $listeAvisReçus;
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

                    // On regarde si la voiture de départ existe, si ce n'est pas le cas on l'insere dans la bd
                    if (!$managerVoiture->existe($modele, $marque, $nbPlace)) {
                        $managerVoiture->insert($modele, $marque, $nbPlace);
                    }

                    // Récupération du numéro de voiture à partir des autres colonnes
                    $numero_voiture = $managerVoiture->findNum($modele, $marque, $nbPlace);
                }
                $photoProfil = $_FILES['image'];
                if($photoProfil == NULL) {
                    $photoProfil = $etudiant->getPhotoProfil();
                    $managerEtudiant->update($_GET['id'],$_POST['nom'], $_POST['prenom'], $_POST['dateNaiss'], $_POST['mail'], $_POST['tel'], $numero_voiture, $photoProfil);
                }
                else{
                    $photoValide = validerUploadEtPdp($photoProfil, $messagesErreurs);
                    if(!empty($messagesErreurs)) {
                        $template = $this->getTwig()->load('profil.html.twig');
        
                        echo $template->render(array(
                            'erreurs'=> $messagesErreurs,
                        ));
                    } 
                    else {
                        $dir = "images"; // Nom du dossier contenant les photos
                        if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                            $photoValide = rand(0, 2147483647) . ".png";
                            move_uploaded_file($_FILES["image"]["tmp_name"], "$dir/$photoValide");
                        }
                        $managerEtudiant->update($_GET['id'],$_POST['nom'], $_POST['prenom'], $_POST['dateNaiss'], $_POST['mail'], $_POST['tel'], $numero_voiture, $photoValide);
                    }
                }
                
                echo "<div id=modalTriggerModif></div>";
            }
        }

    }
    
}