<?php
// Démarrage de la session (si nécessaire pour conserver des informations utilisateur)
session_start();

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
?>
<input>
