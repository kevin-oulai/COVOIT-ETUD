<?php 
//ajout de l’autoload de composer
require_once 'include.php';

$template = $twig->load('index.html.twig');

echo $template->render(array(
   ));
   