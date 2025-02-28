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
        $template = $this->getTwig()->load('backOffice.html.twig');
        echo $template->render(array(
            'badges' => $listeBadge
        ));

        if(isset($_GET['action'])){
            if($_GET['action'] == "ajouter"){
                $listeErreurs = [];
                if(validerTitre($_POST['titre'],$listeErreurs) && validerImage($_POST['image'], $listeErreurs) && validerDescription($_POST['description'], $listeErreurs)) {
                    $managerBadge = new BadgeDao($this->getPdo());
                    $managerBadge->insert($_POST['titre'], $_POST['image'], $_POST['description']);
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
        }
    }
}