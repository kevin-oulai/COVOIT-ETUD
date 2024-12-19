<?php

function validerNom(?string $nom, array &$messagesErreurs): bool
{
    $valide = true;
    // 1. Champs obligatoires : vérifier la présence du champ
    if (empty($nom)) {
        $messagesErreurs[] = "Le nom est obligatoire.";
        $valide = false;

    } else {

        // 2. Type de données : vérifier que le type de données est correct
        if (!is_string($nom)) {
            $messagesErreurs[] = "Le nom doit être une chaîne de caractères.";
            $valide = false;
        }

        // 3. Longueur des chaînes : vérifier la longueur minimale et maximale
        if (strlen($nom) < 2 || strlen($nom) > 50) {
            $messagesErreurs[] = "Le nom doit contenir entre 2 et 50 caractères.";
            $valide = false;
        }
    }
    return $valide;
}

function validerPrenom(?string $prenom, array &$messagesErreurs): bool
{
    $valide = true;
    // 1. Champs obligatoires : vérifier la présence du champ
    if (empty($prenom)) {
        $messagesErreurs[] = "Le prénom est obligatoire.";
        $valide = false;

    } else {

        // 2. Type de données : vérifier que le type de données est correct
        if (!is_string($prenom)) {
            $messagesErreurs[] = "Le prénom doit être une chaîne de caractères.";
            $valide = false;
        }

        // 3. Longueur des chaînes : vérifier la longueur minimale et maximale
        if (strlen($prenom) < 2 || strlen($prenom) > 50) {
            $messagesErreurs[] = "Le prénom doit contenir entre 2 et 50 caractères.";
            $valide = false;
        }
    }
    return $valide;
}

function validerMail(string $email, array &$messageErreurs): bool
{

    $valide = true;

    // 1. Champs obligatoires : vérifier la présence du champ
    if (empty($email)) {
        $messageErreurs[] = "L'adresse email est obligatoire";
        $valide = false;
    }

    // 2. Type de données : vérifier que l'email est une chaine de charactères
    if (!is_string($email)) {
        $messageErreurs[] = "L'adresse mail doit être une chaine de charatères";
        $valide = false;
    }

    // 3. Longueur des chaines : vérifier la longueur minimal et maximal (entre 5 et 255)
    if (strlen($email) < 5 || strlen($email) > 255) {
        $messageErreurs[] = "L'adresse email doit comporter entre 5 et 255 charactères";
        $valide = false;
    }

    // 4. Format de données : vérifier le format de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $messageErreurs[] = "L'adresse email est invalide";
        $valide = false;
    }

    // 5. Plages de valeurs : non pertinent

    // 6. Fichiers uploadé : non pertinent

    return $valide;
}

function validerTelephone($num, array &$messageErreurs): bool
{

    $valide = true;

    // 1. Champs obligatoires : vérifier la présence du champ
    if (empty($num)) {
        $messageErreurs[] = "Le numéro de téléphone est obligatoire";
        $valide = false;
    }

    // 2. Type de données : vérifier que le numero de telephone est une chaine de charactères
    if (!is_string($num)) {
        $messageErreurs[] = "Le numéro de téléphone doit être une chaine de charatères";
        $valide = false;
    }

    // 3. Longueur des chaines : vérifier la longueur minimal et maximal (10)
    if (strlen($num) != 10) {
        $messageErreurs[] = "Le numéro de téléphone doit comporter 10 charactères";
        $valide = false;
    }

    // 4. Format de données : vérifier le format du numéro de téléphone
    if (!is_numeric($num)) {
        $messageErreurs[] = "Le numéro de téléphone est invalide";
        $valide = false;
    }

    // 5. Plages de valeurs : non pertinent

    // 6. Fichiers uploadé : non pertinent

    return $valide;
}

function validerDateDeNaissance($dateNaiss, array &$messageErreurs): bool
{

    $valide = true;

    // 1. Champs obligatoires : vérifier la présence du champ
    if (empty($dateNaiss)) {
        $messageErreurs[] = "La date de naissance est obligatoire";
        $valide = false;
    }

    // 2. Type de données : vérifier que la date de naissance est une chaine de charactères
    if (!is_string($dateNaiss)) {
        $messageErreurs[] = "La date de naissance doit être une chaine de charatères";
        $valide = false;
    }

    // 3. Longueur des chaines : vérifier la longueur minimal et maximal (10)
    if (strlen($dateNaiss) != 10) {
        $messageErreurs[] = "La date de naissance doit comporter 10 charactères";
        $valide = false;
    }

    // 4. Format de données : vérifier le format de la date de naissance
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateNaiss)) {
        $messageErreurs[] = "La date de naissance est invalide";
        $valide = false;
    }

    // 5. Plages de valeurs : Vérifier que la date de naissance est comprise entre 1950 et 2006
    // Convertir les dates en timestamp UNIX pour faciliter les comparaisons
    $timestamp = strtotime($dateNaiss);
    $dateMin = strtotime('1950-01-01');
    $dateMax = strtotime('2006-01-01');

    // Vérifier que le timestamp de la date est bien dans les bornes spécifiques
    if ($timestamp < $dateMin || $dateMax > $dateMax) {
        $messageErreurs[] = "La date de naissance est bien entre le 1er janvier 1950 et le 1er janvier 2006";
        $valide = false;
    }

    // 6. Fichiers uploadé : non pertinent

    return $valide;
}

function validerMdp($mdp, array &$messageErreurs)
{

    $valide = true;

    // 1. Champs obligatoires : vérifier la présence du champ
    if (empty($mdp)) {
        $messageErreurs[] = "Le mot de passe est obligatoire";
        $valide = false;
    }

    // 2. Type de données : vérifier que le mot de passe est une chaine de charactères
    if (!is_string($mdp)) {
        $messageErreurs[] = "Le mot de passe doit être une chaine de charatères";
        $valide = false;
    }

    // 3. Longueur des chaines : vérifier la longueur minimal et maximal (entre 8 et 255)
    if (strlen($mdp) < 8 || strlen($mdp) > 255) {
        $messageErreurs[] = "Le mot de passe doit comporter entre 8 et 255 charactères";
        $valide = false;
    }

    // 4. Format de données : vérifier le format du mot de passe
    if (!preg_match('/[A-Za-z]/', $mdp) || !preg_match('/[0-9]/', $mdp) || !preg_match('/[\W_]/', $mdp)) {
        $messageErreurs[] = "Le mot de passe doit contenir au moins une lettre, un chiffre et un symbole";
        $valide = false;
    }

    // 5. Plages de valeurs : non pertinent

    // 6. Fichiers uploadé : non pertinent

    return $valide;
}

function validerPdp($pdp, array &$messageErreurs)
{

    $valide = true;

    // 1. Champs obligatoires : non obligatoire

    if ($pdp['error'] == UPLOAD_ERR_NO_FILE) {
        return $valide;
    }

    // 2. Type de données : Le type de fichier est vérifié au points 6

    // 3. Longueur des chaines : non pertinent pour un fichier

    // 4. Format de données : non pertinent pour un fichier

    // 5. Plages de valeurs : non pertinent pour un fichier

    // 6. Fichiers uploadé : vérifier la taille et le type
    $typeAutorises = ['image/jpeg', 'image/png']; // Types MIME valides en minuscules

    // Vérification du type MIME réel pour contrer les falsifications d'extension
    $typeMimeReel = mime_content_type($pdp['tmp_name']);
    if (!in_array(strtolower($typeMimeReel), $typeAutorises)) {
        $messageErreurs[] = "Le fichier doit être au format JPG ou PNG.";
        $valide = false;
    }

    // Vérification de l'extension de fichier (au cas où le type MIME est mal retourné)
    $extensionFichier = strtolower(pathinfo($pdp['name'], PATHINFO_EXTENSION));
    if (!in_array($extensionFichier, ['jpg', 'jpeg', 'png'])) {
        $messageErreurs[] = "Le fichier doit être au format JPG ou PNG.";
        $valide = false;
    }


    // Vérification du poids du fichier
    $tailleMaxAutoriseeEnOctets = 2 * 1024 * 1024; //2Mo
    if ($pdp['size'] > $tailleMaxAutoriseeEnOctets) {
        $messageErreurs[] = "Le fichier ne doit pas dépasser 2 Mo";
        $valide = false;
    }

    // Supression du fichier temporaire en cas de validation échouée
    if (!$valide) {
        unlink($pdp['tmp_name']);
    }

    return $valide;
}

function validerUploadEtPdp($pdp, array &$messageErreurs)
{
    // Initialisation de la photo de profil à true
    $valide = true;

    // Vérifie la présence et l'absence d'erreurs de téléchargement
    if (isset($pdp) && $pdp['error'] == UPLOAD_ERR_OK) {
        // Si le fichier a été télécharger sans erreurs, on procède à la validation du fichier
        $valide = validerPdp($pdp, $messageErreurs);
    } else {
        switch ($pdp['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $messageErreurs[] = "Le fichier la taille maximale du serveur";
                $valide = false;
                break;
            case UPLOAD_ERR_PARTIAL:
                $messageErreurs[] = "Le fichier n'a été partiellement téléchargement";
                $valide = false;
                break;
            case UPLOAD_ERR_NO_FILE:
                $valide = true;
                break;
            default:
                $messageErreurs[] = "Erreur lors du téléchargement du fichier";
                $valide = false;
                break;
        }


    }

    return $valide;
}


function validerNumeroCarte(?string $numeroCarte, array &$messagesErreurs): bool
{
    $valide = true;
    $numeroCarte = str_replace(" ", "", $numeroCarte);

    // 1. Champs obligatoires : vérifier la présence du champ
    if (empty($numeroCarte)) {
        $messagesErreurs[] = "Le numéro de carte est obligatoire.";
        $valide = false;

    } else {

        // 2. Type de données : vérifier que le type de données est correct
        if (!is_string($numeroCarte)) {
            $messagesErreurs[] = "Le numéro de carte doit être une chaîne de caractères.";
            $valide = false;
        }

        // 3. Longueur des chaînes : vérifier la longueur minimale et maximale
        if (strlen($numeroCarte) != 16) {
            $messagesErreurs[] = "Le numéro de carte doit contenir 16 caractères.";
            $valide = false;
        }

        // 4. Format de données : vérifier le format de données
        if (!preg_match("/^[0-9]+$/", $numeroCarte)) {
            $messagesErreurs[] = "Le numéro de carte doit contenir uniquement des chiffres.";
            $valide = false;

        }

        if (preg_match("/^[0-9]{16}$/", $numeroCarte)) {
            // 5. Valeurs autorisées : vérifier que la valeur est autorisée
            // Conversion de la chaîne en tableau de chiffres
            $numeroCarte = str_split($numeroCarte);
            $numeroCarte = array_map("intval", $numeroCarte);

            // Inversion du tableau pour faciliter les calculs
            $numeroCarte = array_reverse($numeroCarte);

            // Vérification via l'algorithme de Luhn
            //  VARIABLES
            $somme = 0;
            $tailleNumeroCarte = count($numeroCarte);

            // TRAITEMENTS
            // Parcours
            for ($indiceNumero = 0; $indiceNumero < $tailleNumeroCarte; $indiceNumero++) {
                // Si l'indice est impair
                if ($indiceNumero % 2 == 1) {
                    // On double la valeur
                    $numeroCarte[$indiceNumero] *= 2;

                    // Si la valeur est supérieure à 9
                    if ($numeroCarte[$indiceNumero] > 9) {
                        // On soustrait 9
                        $numeroCarte[$indiceNumero] -= 9;
                    }

                    // On ajoute la valeur à la somme
                    $somme += $numeroCarte[$indiceNumero];

                } else {
                    // On ajoute la valeur à la somme
                    $somme += $numeroCarte[$indiceNumero];
                }
            }

            // RESULTATS
            // Si la somme est un multiple de 10
            if ($somme % 10 != 0) {
                $messagesErreurs[] = "Le numéro de carte n'est pas valide.";
                $valide = false;
            }
        }

    }

    return $valide;
}

function validerDateExpiration(?string $dateExpiration, array &$messagesErreurs): bool
{
    $valide = true;

    // 1. Champs obligatoires : vérifier la présence du champ
    if (empty($dateExpiration)) {
        $messagesErreurs[] = "La date d'expiration est obligatoire.";
        $valide = false;

    } else {

        // 2. Type de données : vérifier que le type de données est correct
        if (!is_string($dateExpiration)) {
            $messagesErreurs[] = "La date d'expiration doit être une chaîne de caractères.";
            $valide = false;
        }

        // 3. Longueur des chaînes : vérifier la longueur minimale et maximale
        if (strlen($dateExpiration) != 5) {
            $messagesErreurs[] = "La date d'expiration doit contenir 5 caractères.";
            $valide = false;
        }

        // 4. Format de données : vérifier le format de données
        if (!preg_match("/^[0-9]{2}\/[0-9]{2}$/", $dateExpiration)) {
            $messagesErreurs[] = "La date d'expiration doit être au format MM/AA.";
            $valide = false;

        } else {

            // 5. Valeurs autorisées : vérifier que la valeur est autorisée
            $dateExpiration = explode("/", $dateExpiration);
            $mois = intval($dateExpiration[0]);
            $annee = intval($dateExpiration[1]);

            // Vérification de la validité de la date
            if ($mois < 0 || $mois > 12) {
                $messagesErreurs[] = "Le mois de la date d'expiration doit être compris entre 01 et 12.";
                $valide = false;

            } else if ($annee < 0 || $annee > 99) {

                $messagesErreurs[] = "L'année de la date d'expiration doit être comprise entre 00 et 99.";
                $valide = false;

            } else {

                // Vérification de la date d'expiration
                // Définition des dates
                $dateActuelle = new DateTime();
                $dateExpiration = new DateTime("20" . $annee . "-" . $mois . "-01");

                // Comparaison
                if ($dateExpiration < $dateActuelle) {
                    $messagesErreurs[] = "La date d'expiration est dépassée.";
                    $valide = false;
                }
            }
        }
    }

    return $valide;
}

function validerCodeSecurite(?string $codeSecurite, array &$messagesErreurs): bool
{
    $valide = true;

    // 1. Champs obligatoires : vérifier la présence du champ
    if (empty($codeSecurite)) {
        $messagesErreurs[] = "Le code de sécurité est obligatoire.";
        $valide = false;

    } else {

        // 2. Type de données : vérifier que le type de données est correct
        if (!is_string($codeSecurite)) {
            $messagesErreurs[] = "Le code de sécurité doit être une chaîne de caractères.";
            $valide = false;
        }

        // 3. Longueur des chaînes : vérifier la longueur minimale et maximale
        if (strlen($codeSecurite) != 3) {
            $messagesErreurs[] = "Le code de sécurité doit contenir 3 caractères.";
            $valide = false;
        }

        // 4. Format de données : vérifier le format de données
        if (!preg_match("/^[0-9]+$/", $codeSecurite)) {
            $messagesErreurs[] = "Le code de sécurité doit contenir uniquement des chiffres.";
            $valide = false;
        }
    }

    return $valide;
}

function validerNote(string $note, array &$messagesErreurs): bool
{
    $valide = true;
    //    Champ obligatoire
    if (empty($note)) {
        $valide = false;
        $messagesErreurs[] = "Vous devez donner une note";
    }
    //    Type Entier
    if (!is_string($note)) {
        $valide = false;
        $messagesErreurs[] = "Valeur de note invalide";
    }
    //    Longueur 1
//    Aucun format
//    Plage de valeur 0 - 5
    if ($note < '0' || $note > '5') {
        $valide = false;
        $messagesErreurs[] = "La note doit être comprise entre 1 et 5";
    }
    //    Pas un fichier
    return $valide;
}

function validerCommentaire(string $commentaire, array &$messagesErreurs): bool
{
    $valide = true;
    //Champ non-obligatoire

    //Type chaine de carateres
    if (!is_string($commentaire)) {
        $valide = false;
        $messagesErreurs[] = "Le commentaire doit être une chaine de caractères";
    }
    //Longueur < 255
    if (strlen($commentaire) > 255) {
        $valide = false;
        $messagesErreurs[] = "Taille de commentaire supérieure à 255";
    }
    //Aucun format
    //Pas de plage de valeur
    //Pas un fichier
    return $valide;
}

global $pdo;

$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function validationPlageHoraire($heureDep, $heureArr, $dateDep, &$messagesErreur): bool
{
    global $pdo;
    $valide = true;
    //    - Champ obligatoire
    if (empty($heureDep) || empty(($heureArr))) {
        $valide = false;
        $messagesErreur[] = 'Veuillez renseigner une plage d\'horaire';
    }
    //    - Type time/string
//    - Longueur time
//    - Format HH:MM
    if ((!preg_match('/^[0-9]{2}:[0-9]{2}$/', $heureDep) || !preg_match('/^[0-9]{2}:[0-9]{2}$/', $heureArr)) && $valide == true) {
        $valide = false;
        $messagesErreur[] = 'Format d\'heure invalide';
    }
    //    - Plage : Ne pas avoir d'autre trajet où l'heure de départ OU d'arrivée soit comprise entre l'heure de départ et d'arrivée saisies.
//  Ne pas avoir de trajet ou l'heure de départ est inférieur à l'heure de départ saisie ET où l'heure d'arrivée est supérieure à l'heure d'arrivée saisie
    if ($heureArr <= $heureDep) {
        $valide = false;
        $messagesErreur[] = 'L\'heure de départ doit être inférieure à l\'heure d\'arrivée';
    }

    $managerTrajet = new TrajetDao($pdo);
    $trajets = $managerTrajet->findAllByConducteur($GLOBALS['CLIENT']->getNumero());
    foreach ($trajets as $trajet) {
        if ((($trajet['heureDep'] > $heureDep && $trajet['heureDep'] < $heureArr) || ($trajet['heureArr'] > $heureDep && $trajet['heureArr'] < $heureArr) || ($trajet['heureDep'] < $heureDep && $trajet['heureArr'] > $heureArr)) && $valide == true && $trajet['dateDep'] == $dateDep) {
            $valide = false;
            $messagesErreur[] = 'Attention ! Vous avez un ou plusieurs trajets au même moment.';
        }
    }

    //- Pas de fichier

    return $valide;
}

function validationPrix($prix, &$messagesErreur): bool
{
    $valide = true;
    //    - Champ obligatoire
    if (empty($prix)) {
        $valide = false;
        $messagesErreur[] = 'Veuillez renseigner un prix';
    }
    //    - Type int
    if (!preg_match('/^[0-9]{1,3}$/', $prix) && $valide == true) {
        $valide = false;
        $messagesErreur[] = 'Le prix doit etre un nombre compris en 1 et 999';
    }
    //    - Longueur < 4
//    - Aucun format
//    - Plage : 1 - 999
    if (($prix < 1 || $prix > 999) && $valide == true) {
        $valide = false;
        $messagesErreur[] = 'Le prix doit être compris entre 1 et 999';
    }
    //    - Pas de fichier
    return $valide;
}

function validationNbPlaces($nbPlaces, &$messagesErreur): bool
{
    global $pdo;
    $valide = true;
    //    - Champ obligatoire
    if (empty($nbPlaces)) {
        $valide = false;
        $messagesErreur[] = 'Veuillez renseigner un nombre de places';
    }
    //    - Type int
    if (!preg_match('/^[0-9]{1,3}$/', $nbPlaces) && $valide == true) {
        $valide = false;
        $messagesErreur[] = 'Le nombre de places doit etre un nombre compris en 1 et 999';
    }
    //    - Longueur 1
//    - Aucun format
//    - Plage 1 - Nombre de place de la voiture de l'utilisateur
    $managerVoiture = new VoitureDao($pdo);
    $voiture = $managerVoiture->findByEtudiant($GLOBALS['CLIENT']->getNumero());
    $nbPlacesMax = $voiture->getNbPlace();
    if (($nbPlaces < 1 || $nbPlaces > $nbPlacesMax) && $valide == true) {
        $valide = false;
        $messagesErreur[] = 'Le nombre de places doit être compris en 1 et ' . $nbPlacesMax . " (nombre de places de votre " . $voiture->getMarque() . " " . $voiture->getModele() . ").";
    }
    //- Pas de fichier
    return $valide;
}

function validationLieuDepart($lieuDep, &$messagesErreur): bool
{
    $valide = true;
    //    - Champ obligatoire
    if (empty($lieuDep)) {
        $valide = false;
        $messagesErreur[] = 'Veuillez renseigner un lieu de départ';
    }
    //    - Type string
//    - Longueur
//    - Format 'Nombre, string, string'
    if (!preg_match('/^[0-9]{1,3}\s[a-zA-Z\s]+,[a-zA-Z\s]+$/', $lieuDep) && $valide == true) {
        $valide = false;
        $messagesErreur[] = 'Format de lieu (de départ) invalide';
    }
    //    - Pas de plage
//    - Pas de fichier
    return $valide;
}

function validationLieuArrivee($lieuArr, &$messagesErreur): bool
{
    $valide = true;
    //    - Champ obligatoire
    if (empty($lieuArr)) {
        $valide = false;
        $messagesErreur[] = 'Veuillez renseigner un lieu d\'arrivée';
    }
    //    - Type string
//    - Longueur
//    - Format 'Nombre, string, string'
    if (!preg_match('/^[0-9]{1,3}\s[a-zA-Z\s]+,[a-zA-Z\s]+$/', $lieuArr) && $valide == true) {
        $valide = false;
        $messagesErreur[] = 'Format de lieu (d\'arrivée) invalide';
    }
    //    - Pas de plage
//    - Pas de fichier
    return $valide;
}

function validationDateDep($dateDep, &$messagesErreur): bool
{
    $valide = true;
    //- Champ obligatoire
    if (empty($dateDep)) {
        $valide = false;
        $messagesErreur[] = 'Veuillez renseigner une date de départ';
    }
    //    - Type string
//    - Longueur
//    - Format YYYY-MM-DD
//    if(!preg_match('/^\d[4]-\d[2]-\d[2]$/', $dateDep) && $valide == true){
//        $valide = false;
//        $messagesErreur[] = 'Format de date invalide';
//    }
//    - Plage - Aujourd'hui - ...
    $today = date('Y-m-d');
    if ($today > $dateDep && $valide == true) {
        $valide = false;
        $messagesErreur[] = 'Veuillez saisir une date valide (après aujourd\'hui)';
    }
    //- Pas de fichier
    return $valide;
}