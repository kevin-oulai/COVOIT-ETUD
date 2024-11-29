<?php

class ControllerInscription extends Controller{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }


    public function ajoutBd()
    {
        
        $managerEtudiant = new EtudiantDAO($this->getPDO());
        $resul = $managerEtudiant->verifMail($_POST["mail"]);
        $managerEtudiant->ajoutEtudiant($_POST["Nom"],$_POST["Prenom"],$_POST["mail"],$_POST["tel"],$resul);

    }


    public function afficher(){
            $template = $this->getTwig()->load('inscription.html.twig');

            echo $template->render(array(
            ));     

   }



    
}