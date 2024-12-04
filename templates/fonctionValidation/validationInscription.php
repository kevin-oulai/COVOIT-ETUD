<?php

function validerPrenom(string $prenom, array &$messageErreurs): bool
{

    $valide = true;

    // 1. Champs obligatoires : vérifier la présence du champ
    if(empty($prenom))
    {
        $messageErreurs[] = "Le prénom est obligatoire";
        $valide = false;
    }

    // 2. Type de données : vérifier que le prenom est une chaine de charactères
    if(!is_string($prenom))
    {
        $messageErreurs[] = "Le prénom doit être une chaine de charatères";
        $valide = false;
    }

    // 3. Longueur des chaines : vérifier la longueur minimal et maximal (entre 3 et 50)
    if(strlen($prenom)<3 || strlen($prenom)>50)
    {
        $messageErreurs[] = "Le prénom doit comporter entre 3 et 50 charactères";
        $valide = false;
    }
    // 4. Format de données : non pertinent

    // 5. Plages de valeurs : non pertinent

    // 6. Fichiers uploadé : non pertinent

    return $valide;
}

function validerNom(string $nom, array &$messageErreurs): bool
{

    $valide = true;

    // 1. Champs obligatoires : vérifier la présence du champ
    if(empty($nom))
    {
        $messageErreurs[] = "Le nom est obligatoire";
        $valide = false;
    }

    // 2. Type de données : vérifier que le prenom est une chaine de charactères
    if(!is_string($prenom))
    {
        $messageErreurs[] = "Le nom doit être une chaine de charatères";
        $valide = false;
    }

    // 3. Longueur des chaines : vérifier la longueur minimal et maximal (entre 1 et 100)
    if(strlen($prenom)<1 || strlen($prenom)>100)
    {
        $messageErreurs[] = "Le prénom doit comporter entre 1 et 100 charactères";
        $valide = false;
    }
    // 4. Format de données : non pertinent

    // 5. Plages de valeurs : non pertinent

    // 6. Fichiers uploadé : non pertinent

    return $valide;
}

function validerMail(string $email, array &$messageErreurs): bool
{

    $valide = true;

    // 1. Champs obligatoires : vérifier la présence du champ
    if(empty($email))
    {
        $messageErreurs[] = "L'adresse email est obligatoire";
        $valide = false;
    }

    // 2. Type de données : vérifier que l'email est une chaine de charactères
    if(!is_string($email))
    {
        $messageErreurs[] = "L'adresse mail doit être une chaine de charatères";
        $valide = false;
    }

    // 3. Longueur des chaines : vérifier la longueur minimal et maximal (entre 5 et 255)
    if(strlen($email)<5 || strlen($email)>255)
    {
        $messageErreurs[] = "L'adresse email doit comporter entre 5 et 255 charactères";
        $valide = false;
    }
    
    // 4. Format de données : vérifier le format de l'email
    if(!filter_var($email,FILTRER_VALIDATE_EMAIL))
    {
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
    if(empty($num))
    {
        $messageErreurs[] = "Le numéro de téléphone est obligatoire";
        $valide = false;
    }

    // 2. Type de données : vérifier que le numero de telephone est une chaine de charactères
    if(!is_string($email))
    {
        $messageErreurs[] = "Le numéro de téléphone doit être une chaine de charatères";
        $valide = false;
    }

    // 3. Longueur des chaines : vérifier la longueur minimal et maximal (10)
    if(strlen($email)!=10)
    {
        $messageErreurs[] = "Le numéro de téléphone doit comporter 10 charactères";
        $valide = false;
    }
    
    // 4. Format de données : vérifier le format du numéro de téléphone
    if(!$email.isdigit())
    {
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
    if(empty($dateNaiss))
    {
        $messageErreurs[] = "La date de naissance est obligatoire";
        $valide = false;
    }

    // 2. Type de données : vérifier que la date de naissance est une chaine de charactères
    if(!is_string($dateNaiss))
    {
        $messageErreurs[] = "La date de naissance doit être une chaine de charatères";
        $valide = false;
    }

    // 3. Longueur des chaines : vérifier la longueur minimal et maximal (10)
    if(strlen($dateNaiss)!=10)
    {
        $messageErreurs[] = "La date de naissance doit comporter 10 charactères";
        $valide = false;
    }
    
    // 4. Format de données : vérifier le format de la date de naissance
    if(!preg_match('/^\d{4}-\d{2}-\d{2}$/',$dateNaiss))
    {
        $messageErreurs[] = "La date de naissance est invalide";
        $valide = false;
    }

    // 5. Plages de valeurs : Vérifier que la date de naissance est comprise entre 1950 et 2006
    // Convertir les dates en timestamp UNIX pour faciliter les comparaisons
    $timestamp = strtotime($date);
    $dateMin = strtotime('1950-01-01');
    $dateMax = strtotime('2006-01-01');

    // Vérifier que le timestamp de la date est bien dans les bornes spécifiques
    if($timestamp < $dateMin || $dateMax > $dateMax)
    {
        $messageErreurs[] = "La date de naissance est bien entre le 1er janvier 1950 et le 1er janvier 2006";
        $valide = false;
    }

    // 6. Fichiers uploadé : non pertinent

    return $valide;
}

function validerMdp($mdp,array &$messageErreurs)
{
    
    $valide = true;

    // 1. Champs obligatoires : vérifier la présence du champ
    if(empty($mdp))
    {
        $messageErreurs[] = "Le mot de passe est obligatoire";
        $valide = false;
    }

    // 2. Type de données : vérifier que le mot de passe est une chaine de charactères
    if(!is_string($mdp))
    {
        $messageErreurs[] = "Le mot de passe doit être une chaine de charatères";
        $valide = false;
    }

    // 3. Longueur des chaines : vérifier la longueur minimal et maximal (entre 8 et 255)
    if(strlen($email)<8 || strlen($email)>255)
    {
        $messageErreurs[] = "Le mot de passe doit comporter entre 8 et 255 charactères";
        $valide = false;
    }
    
    // 4. Format de données : vérifier le format du mot de passe
    if (!preg_match('/[A-Za-z]/', $mdp) || !preg_match('/[0-9]/', $mdp) || !preg_match('/[\W_]/', $mdp))
    {
        $messageErreurs[] = "Le mot de passe doit contenir au moins une lettre, un chiffre et un symbole";
        $valide = false;
    }

    // 5. Plages de valeurs : non pertinent

    // 6. Fichiers uploadé : non pertinent

    return $valide;
}

function validerPdp($pdp,array &$messageErreurs)
{
    // Initialisation de la photo de profil à true
    $valide = true;

    // Vérifie la présence et l'absence d'erreurs de téléchargement
    if(isset($pdp) && $pdp['error'] == UPLOAD_ERR_OK)
    {
        // Si le fichier a été télécharger sans erreurs, on procède à la validation du fichier
        
    }

    // 1. Champs obligatoires : vérifier la présence du champ
    if(empty($mdp))
    {
        $messageErreurs[] = "Le mot de passe est obligatoire";
        $valide = false;
    }

    // 2. Type de données : vérifier que le mot de passe est une chaine de charactères
    if(!is_string($mdp))
    {
        $messageErreurs[] = "Le mot de passe doit être une chaine de charatères";
        $valide = false;
    }

    // 3. Longueur des chaines : vérifier la longueur minimal et maximal (entre 8 et 255)
    if(strlen($email)<8 || strlen($email)>255)
    {
        $messageErreurs[] = "Le mot de passe doit comporter entre 8 et 255 charactères";
        $valide = false;
    }
    
    // 4. Format de données : vérifier le format du mot de passe
    if (!preg_match('/[A-Za-z]/', $mdp) || !preg_match('/[0-9]/', $mdp) || !preg_match('/[\W_]/', $mdp))
    {
        $messageErreurs[] = "Le mot de passe doit contenir au moins une lettre, un chiffre et un symbole";
        $valide = false;
    }

    // 5. Plages de valeurs : non pertinent

    // 6. Fichiers uploadé : non pertinent

    return $valide;
}