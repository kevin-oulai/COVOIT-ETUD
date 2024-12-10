<?php
include 'modeles/etudiant.dao.php';
include 'modeles/etudiant.class.php';

//Connexion à la base de données
define('DB_HOST', 'lakartxela.iutbayonne.univ-pau.fr');
define('DB_NAME', 'koulai001_pro');
define('DB_USER', 'koulai001_pro');
define('DB_PASS', 'koulai001_pro');
session_start();
if (isset($_SESSION['login']) || isset($_SESSION['pwd'])) {
    $GLOBALS['STATUS'] = 'connected';

    $GLOBALS['CLIENT'] = $_SESSION['CLIENT'];

    if($_SESSION['voiture'] != null){
        $GLOBALS['CONDUCTEUR'] = 'true';
    }
    else{
        $GLOBALS['CONDUCTEUR'] = 'false';
    }
}
else{
    $GLOBALS['CONDUCTEUR'] = 'false';
    $GLOBALS['CLIENT'] = new Etudiant();
    $GLOBALS['STATUS'] = 'disconnected';
}

