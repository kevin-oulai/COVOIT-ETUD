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
        $template = $this->getTwig()->load('backOffice.html.twig');
        echo $template->render(array(
        ));
    }
}