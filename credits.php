<?php
//ajout de l’autoload de composer
require_once 'include.php';
$template = $twig->load('credits.html.twig');
echo $template->render();

