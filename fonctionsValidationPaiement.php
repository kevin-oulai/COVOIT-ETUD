<?php

// function validerNom(?string $nom, array &$messagesErreurs): bool
// {
//     $valide = true;
//     // 1. Champs obligatoires : vérifier la présence du champ
//     if (empty($nom)) {
//         $messagesErreurs[] = "Le nom est obligatoire.";
//         $valide = false;

//     } else {

//         // 2. Type de données : vérifier que le type de données est correct
//         if (!is_string($nom)) {
//             $messagesErreurs[] = "Le nom doit être une chaîne de caractères.";
//             $valide = false;
//         }

//         // 3. Longueur des chaînes : vérifier la longueur minimale et maximale
//         if (strlen($nom) < 2 || strlen($nom) > 50) {
//             $messagesErreurs[] = "Le nom doit contenir entre 2 et 50 caractères.";
//             $valide = false;
//         }
//     }
//     return $valide;
// }

// function validerPrenom(?string $prenom, array &$messagesErreurs): bool
// {
//     $valide = true;
//     // 1. Champs obligatoires : vérifier la présence du champ
//     if (empty($prenom)) {
//         $messagesErreurs[] = "Le prénom est obligatoire.";
//         $valide = false;

//     } else {

//         // 2. Type de données : vérifier que le type de données est correct
//         if (!is_string($prenom)) {
//             $messagesErreurs[] = "Le prénom doit être une chaîne de caractères.";
//             $valide = false;
//         }

//         // 3. Longueur des chaînes : vérifier la longueur minimale et maximale
//         if (strlen($prenom) < 2 || strlen($prenom) > 50) {
//             $messagesErreurs[] = "Le prénom doit contenir entre 2 et 50 caractères.";
//             $valide = false;
//         }
//     }
//     return $valide;
// }

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

        if (preg_match("/^[0-9]{16}$/", $numeroCarte)){
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
?>