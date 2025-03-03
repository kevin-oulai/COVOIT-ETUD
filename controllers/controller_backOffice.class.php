<?php
/**
 * @file    controller_backOffice.class.php
 * @author  Candice Dutournier

 * @brief Classe ControllerBackOffice traite les informations envoyées et gére l'ouverture de la vue concernant le back office
 *
 * @details Cette classe permet de traiter les actions de l'utilisateur, modifier les données des modèles et des vues
 *
 * @version 0.1
 * @date    26/02/2025
 */

class ControllerBackOffice extends Controller{
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
     * @brief Affiche la page du back office
     *
     * @return void
     */
    public function afficher(){
        $managerBadge = new BadgeDao($this->getPdo());
        $listeBadge = $managerBadge->findAllBadge();
        $twigparams = array('badges' => $listeBadge);
        if(isset($listeErreurs)){
            $twigparams['listeErreurs'] = $listeErreurs;
        }
        $template = $this->getTwig()->load('backOffice.html.twig');
        echo $template->render($twigparams);

        if(isset($_GET['action'])){
            if($_GET['action'] == "ajouter"){
                $messagesErreurs = [];
                if(isset($_POST["titre"]) && isset($_POST["description"]) && isset($_POST["categorie"]) && isset($_POST["rang"])) {
                    $managerBadge = new BadgeDao($this->getPdo());
                    $titreValide = validerTitre($_POST["titre"], $messagesErreurs);
                    $descriptionValide = validerDescription($_POST["description"], $messagesErreurs);
                    $imageValide = validerUploadEtPdp($_FILES["image"], $messagesErreurs);
                    $categorieValide = validerCategorie($_POST["categorie"], $messagesErreurs);
                    $rangValide = validerRang($_POST["rang"], $messagesErreurs);

                    if(!empty($messagesErreurs)) {
                        $template = $this->getTwig()->load('inscription.html.twig');
        
                        echo $template->render(array(
                            'erreurs'=> $messagesErreurs,
                        ));
                    
                    } else {
                            $dir = "images/assets"; // Nom du dossier contenant les photos
                            $name = "etoile-icon.png";
                            if (is_uploaded_file($_FILES["image"]["tmp_name"]) && !exists($_POST["image"])) {
                                $name = $_POST["image"] . ".png";
                                move_uploaded_file($_FILES["image"]["tmp_name"], "$dir/$name");
                            }
                            $managerEtudiant->insert($_POST["titre"], $name, $_POST["description"]);
        
                            $template = $this->getTwig()->load('connexion.html.twig');
                            echo $template->render(array(
                            ));
                    }
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
                                        <button type=button class='btn btn-primary' onclick=\"location = 'index.php?controleur=backOffice&methode=afficher';\">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id=errorModalTrigger></div>";
                                            
                }
            }
            elseif ($_GET['action'] == "modifier") {
                $numero = $_GET['id'];
                var_dump($numero);
                $badge = $managerBadge->findBadge($numero);
                $messagesErreurs = [];

                validerTitre($_POST['titre'], $messagesErreurs);
                validerDescription($_POST['description'], $messagesErreurs);

                if (!is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    $nomPhoto = $badge->getImage();
                }
                else {
                    validerUploadEtPdp($_FILES["image"], $messagesErreurs);
                    $image = $_FILES["image"]["tmp_name"];

                    if (empty($messagesErreurs)) {
                        $dir = "images/assets"; // Nom du dossier contenant les photos
                        $nomPhoto = $_FILES['image']["name"];
                        move_uploaded_file($image, "$dir/$nomPhoto");
                    }
                }

                if (!empty($messagesErreurs)) {
                    $template = $this->getTwig()->load('backOffice.html.twig');
                    
                    $twig_params['erreurs'] = $messagesErreurs;
                    $twig_params['badges'] = $listeBadge;

                } else {
                    $managerBadge->update($numero, $_POST['titre'], $_POST['description'], $nomPhoto);
                    echo "<div id=modalTriggerModif></div>";
                }
            }
            elseif ($_GET['action'] == "supprimer") {
                $numero = $_GET['id'];
                var_dump($numero);
                $badge = $managerBadge->findBadge($numero);
                $managerBadge->delete($numero);
                echo "<div id=modalTriggerSuppr></div>";
            }
        }
    }
}