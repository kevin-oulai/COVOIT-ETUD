<?php

class ControllerEtudiant extends Controller{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    public function afficher(){
        $managerEtudiant = new EtudiantDao($this->getPdo());
        $managerVoiture = new VoitureDao($this->getPdo());
        $managerBadge = new BadgeDao($this->getPdo());
        $managerAvisDonnes = new AvisDao($this->getPdo());
        $managerAvisReçus = new AvisDao($this->getPdo());
        $etudiant = $managerEtudiant->find(1);
        $voiture = $managerVoiture->find(1);
        $badge = $managerBadge->find(1);
        $avisDonnes = $managerAvisDonnes->findCommentateur(1);
        $avisReçus = $managerAvisReçus->findConcerne(1);
        //var_dump($avis);
        
        $template = $this->getTwig()->load('profil.html.twig');

        echo $template->render(array(
            'etudiant' => $etudiant,
            'voiture' => $voiture,
            'badge' => $badge,
            'avisDonnes' => $avisDonnes,
            'avisReçus' => $avisReçus,
        ));

        $numero_conducteur = 1; // A changer lorsque les variables de session serons mises en place.
        if($numero_conducteur == 1) {
            
        }
        else {
            //redirection page connexion
        }

    }
    
}