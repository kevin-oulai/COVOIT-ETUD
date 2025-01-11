<?php
/**
* @file    logout.php
* @author  Birembaux Théo

* @brief   Gère la déconnexion en supprimant la session de l'étudiant
*     
*/
// On démarre la session
session_start ();
// On détruit les variables de notre session
session_unset ();

// On détruit notre session
session_destroy ();

// On redirige le visiteur vers la page d'accueil
header ('location: index.php');
exit();
