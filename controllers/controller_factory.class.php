<?php

class ControllerFactory
{
    public static function getController($controleur, Twig\Loader\FilesystemLoader $loader, Twig\Environment $twig)
    {
        $controllerName = "Controller".ucFirst($controleur);
        if (!class_exists($controllerName)) {
            throw new Exception("La classe $controllerName n'existe pas !");
        }
        return new $controllerName($twig, $loader);
    }
}