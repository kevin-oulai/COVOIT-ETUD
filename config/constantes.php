<?php
include 'modeles/etudiant.dao.php';
include 'modeles/etudiant.class.php';
//Connexion à la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'covoit-etud');
define('DB_USER', 'root');
define('DB_PASS', '');
session_start();