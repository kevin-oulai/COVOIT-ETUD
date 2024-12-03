<?php

class ControllerEtudiant extends Controller{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    public function afficher(){
        $num_etudiant = $_SESSION['id'];
        $managerEtudiant = new EtudiantDao($this->getPdo());
        $etudiant = $managerEtudiant->find($num_etudiant);
        $twig_params = array('etudiant' => $etudiant);

        if($managerEtudiant->possedeBadge($num_etudiant)) { // Verifier si l'étudiant possède des badges
            $managerBadge = new BadgeDao($this->getPdo());
            $badge = $managerBadge->find($num_etudiant);
            $twig_params['badge'] = $badge;
        }

        if($managerEtudiant->estConducteur($num_etudiant)) { // Verifier si l'étudiant est un conducteur
            $managerNbTrajet = new EtudiantDao($this->getPdo());
            $managerVoiture = new VoitureDao($this->getPdo());
            $nbTrajet = $managerNbTrajet->findNbTrajets($num_etudiant);
            $voiture = $managerVoiture->findMonEtudiant($num_etudiant);
            $twig_params['nbTrajet'] = $nbTrajet;
            $twig_params['voiture'] = $voiture;
        }

        // Dans etudiant verifier que l'étudiant a posté un avis.
        if($managerEtudiant->aPosteAvis($num_etudiant)) {
            $managerAvisDonnes = new AvisDao($this->getPdo());
            $managerEtudiantConcerne = new EtudiantDao($this->getPdo());
            $etudiantConcerne = $managerEtudiantConcerne->findConcerneParAvis($num_etudiant);
            $avisDonnes = $managerAvisDonnes->findCommentateur($num_etudiant);
            $twig_params['avisDonnes'] = $avisDonnes;
            $twig_params['etudiantConcerne'] = $etudiantConcerne;
        }

        if($managerEtudiant->aRecuAvis($num_etudiant)) {
            $managerAvisReçus = new AvisDao($this->getPdo());
            $managerEtudiantCommentateur = new EtudiantDao($this->getPdo());
            $etudiantCommentateur = $managerEtudiantCommentateur->findCommentateurDAvis($num_etudiant);
            $avisReçus = $managerAvisReçus->findConcerne($num_etudiant);
            $twig_params['avisRecus'] = $avisReçus;
            $twig_params['etudiantCommentateur'] = $etudiantCommentateur;
        }

        $template = $this->getTwig()->load('profil.html.twig');

        echo $template->render($twig_params);

    }
    
}