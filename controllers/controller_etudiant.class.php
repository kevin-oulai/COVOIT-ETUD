<?php

class ControllerEtudiant extends Controller{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    public function afficher(){
        $num_etudiant=1;
        $managerEtudiant = new EtudiantDao($this->getPdo());
        $etudiant = $managerEtudiant->find($num_etudiant);
        $managerEtudiantConcerne = new EtudiantDao($this->getPdo());
        $managerEtudiantCommentateur = new EtudiantDao($this->getPdo());
        $managerNbTrajet = new EtudiantDao($this->getPdo());
        $managerVoiture = new VoitureDao($this->getPdo());
        $managerBadge = new BadgeDao($this->getPdo());
        $managerAvisDonnes = new AvisDao($this->getPdo());
        $managerAvisReçus = new AvisDao($this->getPdo());
        $etudiantConcerne = $managerEtudiantConcerne->findConcerneParAvis($num_etudiant);
        $etudiantCommentateur = $managerEtudiantCommentateur->findCommentateurDAvis($num_etudiant);
        $nbTrajet = $managerNbTrajet->findNbTrajets($num_etudiant);
        $voiture = $managerVoiture->findMonEtudiant($num_etudiant);
        $badge = $managerBadge->find($num_etudiant);
        $avisDonnes = $managerAvisDonnes->findCommentateur($num_etudiant);
        $avisReçus = $managerAvisReçus->findConcerne($num_etudiant);
        //var_dump($avis);
        
        $template = $this->getTwig()->load('profil.html.twig');

        echo $template->render(array(
            'etudiant' => $etudiant,
            'voiture' => $voiture,
            'badge' => $badge,
            'avisDonnes' => $avisDonnes,
            'avisReçus' => $avisReçus,
            'etudiantConcerne' => $etudiantConcerne,
            'etudiantCommentateur' => $etudiantCommentateur,
            'nbTrajet' => $nbTrajet,
        ));

        $numero_conducteur = 1; // A changer lorsque les variables de session serons mises en place.
        if($numero_conducteur == 1) {
            
        }
        else {
            //redirection page connexion
        }

    }
    
}