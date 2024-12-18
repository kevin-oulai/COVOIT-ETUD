<?php

class ControllerConnexion extends Controller{
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        parent::__construct($twig, $loader);
    }

    public function afficher(){
        $template = $this->getTwig()->load('connexion.html.twig');

        echo $template->render(array(
        ));
    }

    public function mdpOublie(){
        $template = $this->getTwig()->load('motdepasseoublie.html.twig');

        echo $template->render(array(
        ));

        // Vérification que le formulaire a été soumis via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            // Récupération de l'email soumis via le formulaire
            $email = $_POST['email'] ?? '';

            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Vérifier que la chaîne récupérée a bien la forme d'un email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                echo "<h1>Erreur</h1>";
                echo "<p>Adresse email invalide.</p>";
                echo '<a href="">Retourner au formulaire</a>';
                exit;
            }

            try
            {
                // Création d'une instance de la classe Etudiant

                $etudiant = new Etudiant(null,null,null,null, $email);

                // Génération du token de réinitialisation
                $token = $etudiant->genererTokenReinitialisation();

                // Simuler l'envoi d'un email en affichant un lien fictif
                $lienReinitialisation = "index?controleur=connexion&methode=reinitialisation_mdp&token=$token";

                echo "<h1>Lien de réinitialisation généré</h1>";
                echo "<a href='$lienReinitialisation'>$lienReinitialisation</a>";
            }
            catch (Exception $e)
            {
                // Gestion des erreurs (par exemple, utilisateur introuvable)
                echo "<h1>Erreur</h1>";
                echo "<p>{$e->getMessage()}</p>";
                echo '<a href="mot_de_passe_oublie.html">Retourner au formulaire</a>';
            }
        }
        else
        {
            // Si le fichier est accédé directement sans soumission du formulaire
            // echo "<meta http-equiv='refresh' content='0;url=motdepasseoublie.php' />";
            exit;
        }
    }

    public function reinitialisation_mdp(){
        // Vérification de la présence du token dans l'URL
        if (!isset($_GET['token']))
        {
            echo "<h1>Erreur</h1>";
            echo "<p>Token de réinitialisation manquant.</p>";
            exit;
        }

// Récupération et nettoyage du token
        $token = htmlspecialchars($_GET['token']); // Nettoyage pour éviter des failles XSS

// Vérification de la validité du token
        try
        {
            // Connexion à la base de données
            $baseDeDonnees = BD::getInstance();
            $pdo = $baseDeDonnees->getConnexion();

            // Recherche du token en base de données
            $requete = $pdo->prepare(
                'SELECT numero, expiration_token FROM ETUDIANT WHERE token_reinitialisation = :token'
            );
            $requete->execute(['token' => $token]);
            $etudiant = $requete->fetch(PDO::FETCH_ASSOC);

            if (!$etudiant)
            {
                echo "<h1>Erreur</h1>";
                echo "<p>Token invalide ou inexistant.</p>";
                exit;
            }

            // Vérification de la date d'expiration du token
            $expiration = strtotime($etudiant['expiration_token']);
            if ($expiration < time())
            {
                echo "<h1>Erreur</h1>";
                echo "<p>Le token a expiré. Veuillez demander un nouveau lien de réinitialisation.</p>";
                exit;
            }
        }
        catch (Exception $e)
        {
            echo "<h1>Erreur</h1>";
            echo "<p>Une erreur inattendue s'est produite : " . $e->getMessage() . "</p>";
            exit;
        }

        // Si le token est valide, afficher le formulaire pour définir un nouveau mot de passe
        $template = $this->getTwig()->load('reinitialisation_mdp.html.twig');

        echo $template->render(array(
        ));
    }

    public function traiterReinitialisation(){
        echo "";
    }

}