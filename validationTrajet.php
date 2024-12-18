<?php
/* Pour chaque champ :

Champ obligatoire ?

Type de données ?

La longueur des chaines ?

Format des données (ex : Adresse email)

Plage de valeurs

Verification des fichiers uploadés

-------------------------
Heure arrivée / Heure depart:
- Champ obligatoire
- Type time/string
- Longueur time
- Format HH:MM
- Plage : Ne pas avoir d'autre trajet où l'heure de départ OU d'arrivée soit comprise entre l'heure de départ et d'arrivée saisies.
  Ne pas avoir de trajet ou l'heure de départ est inférieur à l'heure de départ saisie ET où l'heure d'arrivée est supérieure à l'heure d'arrivée saisie
- Pas de fichier

---
Prix:
- Champ obligatoire
- Type int
- Longueur < 4
- Aucun format
- Plage : 1 - 999
- Pas de fichier

---
Nombre de places:
- Champ obligatoire
- Type int
- Longueur 1
- Aucun format
- Plage 1 - Nombre de place de la voiture de l'utilisateur
- Pas de fichier

---
Lieu de départ:
- Champ obligatoire
- Type string
- Longueur
- Format 'Nombre, string, string'
- Pas de plage
- Pas de fichier

---
Lieu de d'arrivée:
- Champ obligatoire
- Type string
- Longueur
- Format 'Nombre, string, string'
- Pas de plage
- Pas de fichier

---
Date de départ:
- Champ obligatoire
- Type string
- Longueur
- Format YYYY-MM-DD
- Plage - Aujourd'hui - ...
- Pas de fichier
*/

global $pdo;

$pdo = new PDO('mysql:host='. DB_HOST . ';dbname='. DB_NAME, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function validationPlageHoraire($heureDep, $heureArr,$dateDep, &$messagesErreur): bool{
    global $pdo;
    $valide = true;
//    - Champ obligatoire
    if(empty($heureDep) || empty(($heureArr))){
        $valide = false;
        $messagesErreur[] = 'Veuillez renseigner une plage d\'horaire';
    }
//    - Type time/string
//    - Longueur time
//    - Format HH:MM
    if((!preg_match('/^[0-9]{2}:[0-9]{2}$/', $heureDep) || !preg_match('/^[0-9]{2}:[0-9]{2}$/', $heureArr)) && $valide == true){
        $valide = false;
        $messagesErreur[] = 'Format d\'heure invalide';
    }
//    - Plage : Ne pas avoir d'autre trajet où l'heure de départ OU d'arrivée soit comprise entre l'heure de départ et d'arrivée saisies.
//  Ne pas avoir de trajet ou l'heure de départ est inférieur à l'heure de départ saisie ET où l'heure d'arrivée est supérieure à l'heure d'arrivée saisie
    if($heureArr <= $heureDep){
        $valide = false;
        $messagesErreur[] = 'L\'heure de départ doit être inférieure à l\'heure d\'arrivée';
    }

    $managerTrajet = new TrajetDao($pdo);
    $trajets = $managerTrajet->findAllByConducteur($GLOBALS['CLIENT']->getNumero());
    foreach($trajets as $trajet){
        if((($trajet['heureDep'] > $heureDep && $trajet['heureDep'] < $heureArr ) || ($trajet['heureArr'] > $heureDep && $trajet['heureArr'] < $heureArr ) || ($trajet['heureDep'] < $heureDep && $trajet['heureArr'] > $heureArr )) && $valide==true && $trajet['dateDep'] == $dateDep){
            $valide = false;
            $messagesErreur[] = 'Attention ! Vous avez un ou plusieurs trajets au même moment.';
        }
    }

//- Pas de fichier

    return $valide;
}

function validationPrix($prix, &$messagesErreur): bool{
    $valide = true;
//    - Champ obligatoire
    if(empty($prix)){
        $valide = false;
        $messagesErreur[] = 'Veuillez renseigner un prix';
    }
//    - Type int
    if(!preg_match('/^[0-9]{1,3}$/', $prix) && $valide == true){
        $valide = false;
        $messagesErreur[] = 'Le prix doit etre un nombre compris en 1 et 999';
    }
//    - Longueur < 4
//    - Aucun format
//    - Plage : 1 - 999
    if(($prix < 1 || $prix > 999) && $valide == true){
        $valide = false;
        $messagesErreur[] = 'Le prix doit être compris entre 1 et 999';
    }
//    - Pas de fichier
    return $valide;
}

function validationNbPlaces($nbPlaces, &$messagesErreur): bool{
    global $pdo;
    $valide = true;
//    - Champ obligatoire
    if(empty($nbPlaces)){
        $valide = false;
        $messagesErreur[] = 'Veuillez renseigner un nombre de places';
    }
//    - Type int
    if(!preg_match('/^[0-9]{1,3}$/', $nbPlaces)&& $valide == true){
        $valide = false;
        $messagesErreur[] = 'Le nombre de places doit etre un nombre compris en 1 et 999';
    }
//    - Longueur 1
//    - Aucun format
//    - Plage 1 - Nombre de place de la voiture de l'utilisateur
    $managerVoiture = new VoitureDao($pdo);
    $voiture = $managerVoiture->findByEtudiant($GLOBALS['CLIENT']->getNumero());
    $nbPlacesMax = $voiture->getNbPlace();
    if(($nbPlaces < 1 || $nbPlaces > $nbPlacesMax) && $valide == true){
        $valide = false;
        $messagesErreur[] = 'Le nombre de places doit être compris en 1 et '. $nbPlacesMax ." (nombre de places de votre ". $voiture->getMarque() . " " . $voiture->getModele() .").";
    }
//- Pas de fichier
    return $valide;
}

function validationLieuDepart($lieuDep, &$messagesErreur): bool{
    $valide = true;
//    - Champ obligatoire
    if(empty($lieuDep)){
        $valide = false;
        $messagesErreur[] = 'Veuillez renseigner un lieu de départ';
    }
//    - Type string
//    - Longueur
//    - Format 'Nombre, string, string'
    if(!preg_match('/^[0-9]{1,3}\s[a-zA-Z\s]+,[a-zA-Z\s]+$/', $lieuDep) && $valide == true){
        $valide = false;
        $messagesErreur[] = 'Format de lieu (de départ) invalide';
    }
//    - Pas de plage
//    - Pas de fichier
    return $valide;
}

function validationLieuArrivee($lieuArr, &$messagesErreur): bool{
    $valide = true;
//    - Champ obligatoire
    if(empty($lieuArr)){
        $valide = false;
        $messagesErreur[] = 'Veuillez renseigner un lieu d\'arrivée';
    }
//    - Type string
//    - Longueur
//    - Format 'Nombre, string, string'
    if(!preg_match('/^[0-9]{1,3}\s[a-zA-Z\s]+,[a-zA-Z\s]+$/', $lieuArr) && $valide == true){
        $valide = false;
        $messagesErreur[] = 'Format de lieu (d\'arrivée) invalide';
    }
//    - Pas de plage
//    - Pas de fichier
    return $valide;
}

function validationDateDep($dateDep, &$messagesErreur): bool{
    $valide = true;
//- Champ obligatoire
    if(empty($dateDep)){
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
    if($today > $dateDep && $valide == true){
        $valide = false;
        $messagesErreur[] = 'Veuillez saisir une date valide (après aujourd\'hui)';
    }
//- Pas de fichier
    return $valide;
}