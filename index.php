<?php 
//ajout de l’autoload de composer
require_once 'include.php';


$pdo = Bd::getInstance()->getConnexion();

$managerEtudiant = new EtudiantDao($pdo);
$etudiant = $managerEtudiant->find(1);
var_dump($etudiant);

$template = $twig->load('index.html.twig');

echo $template->render(array(
   ));
   