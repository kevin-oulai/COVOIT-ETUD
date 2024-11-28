<?php

//Connexion à la base de données
define('DB_HOST', 'lakartxela.iutbayonne.univ-pau.fr');
define('DB_NAME', 'koulai001_pro');
define('DB_USER', 'koulai001_pro');
define('DB_PASS', 'koulai001_pro');
session_start();
if (isset($_SESSION['login']) || isset($_SESSION['pwd'])) {
    $GLOBALS['STATUS'] = 'connected';
}
else{
    $GLOBALS['STATUS'] = 'disconnected';
}

