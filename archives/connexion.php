<?php
use Symfony\Component\Yaml\Yaml;

$yaml = Yaml::parse(file_get_contents('config/constantes.yaml'));
$DB_HOST = $yaml['database']['DB_HOST'];
$DB_NAME = $yaml['database']['DB_NAME'];
$DB_USER = $yaml['database']['DB_USER'];
$DB_PASS = $yaml['database']['DB_PASS'];

try {
    $this->pdo = new PDO('mysql:host='. $DB_HOST . ';dbname='. $DB_NAME, $DB_USER, $DB_PASS);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){

    die('Connexion à la base de données échouée : ' . $e->getMessage());
}