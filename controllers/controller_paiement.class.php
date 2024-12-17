<?php
include("fonctionsValidationPaiement.php");

class ControllerPaiement extends Controller
{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }

    public function afficher()
    {
        $formulaireRempli = (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["num_carte"]) && isset($_POST["date_exp"]) && isset($_POST["cvc"]));
        
        if ($formulaireRempli) {
            // VARIABLES
            // Initialisation du tableau des messages d'erreurs
            $messagesErreurs = array();

            $nomValide = validerNom($_POST["nom"], $messagesErreurs);
            $prenomValide = validerPrenom($_POST["prenom"], $messagesErreurs);
            $numCarteValide = validerNumeroCarte($_POST["num_carte"], $messagesErreurs);
            $dateValide = validerDateExpiration($_POST["date_exp"], $messagesErreurs);
            $codeValide = validerCodeSecurite($_POST["cvc"], $messagesErreurs);

            // Si les données sont valides, on affiche un message de succès
            if (empty($messagesErreurs)) {
                $template = $this->getTwig()->load('pagePaiement.html.twig');

                echo $template->render(array(
                    'messageSucces' => "Paiement effectué avec succès !"
                ));

            } else {
                // Sinon, on affiche les messages d'erreurs
                foreach ($messagesErreurs as $message) {
                    echo $message . "<br>";
                }
            }

        } else {
            $template = $this->getTwig()->load('pagePaiement.html.twig');

            echo $template->render(array(
            ));
        }

    }
}