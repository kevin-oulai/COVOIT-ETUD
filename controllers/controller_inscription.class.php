<?php

class ControllerInscription extends Controller{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    public function afficher(){
            $template = $this->getTwig()->load('inscription.html.twig');

            echo $template->render(array(
            ));     

   }



    
}