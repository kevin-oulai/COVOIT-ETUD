<?php
class ControllerPaiement extends Controller
{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }
    public function afficher()
    {
        $formulaireRempli = (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["num_carte"]) && isset($_POST["date_exp"]) && isset($_POST["cvc"]));
        $idTrajet = $_GET["idTrajet"];

        $nom = "";
        $prenom = "";
        $numCarte = "";
        $dateExp = "";
        $cvc = "";

        if ($formulaireRempli) {
            // VARIABLES
            // Initialisation du tableau des messages d'erreurs
            $messagesErreurs = array();

            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $numCarte = $_POST["num_carte"];
            $dateExp = $_POST["date_exp"];
            $cvc = $_POST["cvc"];

            $nomValide = validerNom($nom, $messagesErreurs);
            $prenomValide = validerPrenom($prenom, $messagesErreurs);
            $numCarteValide = validerNumeroCarte($numCarte, $messagesErreurs);
            $dateValide = validerDateExpiration($dateExp, $messagesErreurs);
            $codeValide = validerCodeSecurite($cvc, $messagesErreurs);

            // Si le formulaire comporte des erreurs, envoyer messagesErreurs à la vue
            if (!empty($messagesErreurs)) {
                $template = $this->getTwig()->load('pagePaiement.html.twig');

                echo $template->render(array(
                    'messagesErreurs' => $messagesErreurs,
                    'paiementValide' => false,
                    'idTrajet' => $idTrajet
                ));
            } else {

                // Traitements sur la base de données
                $template = $this->getTwig()->load('pagePaiement.html.twig');

                echo $template->render(array(
                    'paiementValide' => true
                ));
            }

        } else {
            $template = $this->getTwig()->load('pagePaiement.html.twig');

            echo $template->render(array(
                'paiementValide' => false,
                'idTrajet' => $idTrajet
            ));
        }
    }

    public function ajouterPassagerTrajet($idTrajet)
    {

    }
}