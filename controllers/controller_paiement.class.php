<?php
/**
 * @file    controller_paiement.class.php
 * @author  Theo BIREMBAUX, Kevin OULAI

 * @brief Classe ControllerPaiement traite les informations envoyées et gére l'ouverture des vues concernant la page de paiement
 *
 * @details Cette classe permet de traiter les actions de l'utilisateur, modifier les données des modèles et des vues
 *
 * @version 0.1
 * @date    11/01/2025
 */

class ControllerPaiement extends Controller
{
    /**
     * @brief Permet de créer l'instance du controller
     *
     * @param Twig\Environment $twig
     * @param Twig\Loader\FilesystemLoader $loader
     */
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

            $managerTrajet = new TrajetDao($this->getPdo());

            // Si le formulaire comporte des erreurs, envoyer messagesErreurs à la vue
            if (!empty($messagesErreurs)) {
                $template = $this->getTwig()->load('pagePaiement.html.twig');

                echo $template->render(array(
                    'messagesErreurs' => $messagesErreurs,
                    'paiementValide' => false,
                    'idTrajet' => $idTrajet
                ));
            } else {
                // Quand le paiement est valide, j'ajoute le passager au trajet dans la table Choisir                
                $numEtudiant = $_SESSION['CLIENT']->getNumero(); // Récupération du numéro de l'étudiant connecté
                $nbPassager = $_SESSION["nombre_passagers"];
                $nbPassager = intval($nbPassager);
                $idTrajet = intval($idTrajet);
                // On cherche a voir si il a deja une place de reserver pour ce trajet
                if ($managerTrajet->trajetDejaReserver($idTrajet, $numEtudiant)) {
                    $managerTrajet->incrementationNbPlace($idTrajet, $numEtudiant, $nbPassager);
                }
                else {
                    // Ajout du passager au trajet
                    $pdo = $this->getPdo();
                    $query = $pdo->prepare("INSERT INTO CHOISIR (numero_trajet, numero_passager, nbPlaceReserve) VALUES (:idTrajet, :numEtudiant, :nbPassager)");
                    $query->bindParam(':idTrajet', $idTrajet);
                    $query->bindParam(':numEtudiant', $numEtudiant);
                    $query->bindParam(':nbPassager', $nbPassager);
                    $query->execute();
                }
                
                $managerTrajet = new TrajetDao($this->getPdo());
                $managerTrajet->decrementerNbPlace($idTrajet ,$nbPassager);
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