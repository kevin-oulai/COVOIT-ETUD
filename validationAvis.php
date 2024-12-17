<?php
/* Pour chaque champ :

Champ obligatoire ?

Type de données ?

La longueur des chaines ?

Format des données (ex : Adresse email)

Plage de valeurs

Verification des fichiers uploadés

-------------------------
Note :
Champ obligatoire
Type Entier
Longueur 1
Aucun format
Plage de valeur 0 - 5
Pas un fichier

---
Commentaire :
Champ non-obligatoire
Type chaine de carateres
Longueur < 255
Aucun format
Pas de plage de valeur
Pas un fichier

*/

function validerNote(string $note, array &$messagesErreurs): bool
{
    $valide = true;
//    Champ obligatoire
    if(empty($note)){
        $valide = false;
        $messagesErreurs[] = "Vous devez donner une note";
    }
//    Type Entier
    if(!is_string($note)){
        $valide = false;
        $messagesErreurs[] = "Valeur de note invalide";
    }
//    Longueur 1
//    Aucun format
//    Plage de valeur 0 - 5
    if($note < '0' || $note > '5'){
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
    if(!is_string($commentaire)){
        $valide = false;
        $messagesErreurs[] = "Le commentaire doit être une chaine de caractères";
    }
    //Longueur < 255
    if(strlen($commentaire) > 255){
        $valide = false;
        $messagesErreurs[] = "Taille de commentaire supérieure à 255";
    }
    //Aucun format
    //Pas de plage de valeur
    //Pas un fichier
    return $valide;
}