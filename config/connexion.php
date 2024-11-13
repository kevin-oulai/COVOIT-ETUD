<?php
try {
    $this->pdo = new PDO('mysql:host='. DB_HOST . ';dbname='. DB_NAME, DB_USER, DB_PASS);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){

    die('Connexion à la base de données échouée : ' . $e->getMessage());
}