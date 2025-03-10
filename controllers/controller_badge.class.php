<?php
/**
 * @file    controller_badge.class.php
 * @author  Thibault ROSALIE

 * @brief Classe ControllerBadge traite les informations envoyées et gére l'ouverture des vues concernant les badges
 *
 * @details Cette classe permet de traiter les actions de l'utilisateur, modifier les données des modèles et des vues
 *
 * @version 0.1
 * @date    26/02/2025
 */

class ControllerBadge extends Controller {
    /**
     * @brief Permet de créer l'instance du controller
     *
     * @param Twig\Environment $twig
     * @param Twig\Loader\FilesystemLoader $loader
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FilesystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }

    /**
     * @brief Affiche la page descriptive des badges
     */
    public function afficher() {
        $managerBadge = new BadgeDao($this->getPdo());
        $listeBadges = $managerBadge->getAll();

        $listeCategories = array();
        $newListeBadges = array();
        foreach ($listeBadges as $badge) {
            if (!(in_array($badge['categorie'], $listeCategories))) {
                
            }
        }

        $template = $this->getTwig()->load('descriptionBadges.html.twig');
        echo $template->render(array(
            'listeBadges'=>$listeBadges,
        ));
    }
}