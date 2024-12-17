<?php
    include_once("fonctionsValidationPaiement.php");

    // VARIABLES
    // Initialisation du tableau des messages d'erreurs
    $messagesErreurs = array();

    $nomValide = validerNom($_POST["nom"], $messagesErreurs);
    $prenomValide = validerPrenom($_POST["prenom"], $messagesErreurs);
    $numCarteValide = validerNumeroCarte($_POST["num_carte"], $messagesErreurs);
    $dateValide = validerDateExpiration($_POST["date_exp"], $messagesErreurs);
    $codeValide = validerCodeSecurite($_POST["cvc"], $messagesErreurs);

    // Si les données sont valides, on affiche un message de succès
    if ($nomValide && $prenomValide && $numCarteValide && $dateValide && $codeValide) {
        echo "Paiement validé avec succès ! <br>";
        echo "Voici les informations de paiement : <br>";
        echo "Nom : " . $_POST["nom"] . "<br>";
        echo "Prénom : " . $_POST["prenom"] . "<br>";
        echo "Numéro de carte : " . $_POST["num_carte"] . "<br>";
        echo "Date d'expiration : " . $_POST["date_exp"] . "<br>";
        echo "Code de sécurité : " . $_POST["cvc"] . "<br>";

    } else {
        // Sinon, on affiche les messages d'erreurs
        foreach ($messagesErreurs as $message) {
            echo $message . "<br>";
        }
        echo "<a href='pagePaiement.php'>Retour au formulaire de paiement</a>";
    }

    