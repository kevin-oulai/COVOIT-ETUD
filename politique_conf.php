<?php 
require_once 'include.php';


    $template = $twig->load('politique_conf.html.twig');
    echo $template->render(array(
    ));
