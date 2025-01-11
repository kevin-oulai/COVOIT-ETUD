<?php
/**
 * @file    controller_factory.class.php
 * @author  Kevin OULAI

 * @brief Classe ControllerFactory qui sert à créer une instance de tout type de controleur
 *
 * @details Cette classe permet de créer une instance d'un controleur dans un environnement Twig
 *
 * @version 0.1
 * @date    11/01/2025
 */

class ControllerFactory
{
    /**
     * @brief Crée une instance du controleur correspondant au nom du controleur passé en parametre
     *
     * @param string $controleur Controleur à créer
     * @param Twig\Environment $twig
     * @param Twig\Loader\FilesystemLoader $loader
     * @return void
     */
    public static function getController($controleur, Twig\Loader\FilesystemLoader $loader, Twig\Environment $twig)
    {
        $controllerName = "Controller".ucFirst($controleur);
        if (!class_exists($controllerName)) {
            throw new Exception("La classe $controllerName n'existe pas !");
        }
        return new $controllerName($twig, $loader);
    }
}