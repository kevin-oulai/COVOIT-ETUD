<?php 
//ajout de l’autoload de composer
require_once 'include.php';


$pdo = Bd::getInstance()->getConnexion();

$template = $twig->load('index.html.twig');

echo $template->render(array(
   ));