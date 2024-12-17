<?php
include 'modeles/etudiant.dao.php';
include 'modeles/etudiant.class.php';

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

