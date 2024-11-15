<?php

/**
 * @brief Classe Bd pour gérer la connexion à la base de données
 * 
 * @details Cette classe permet de gérer la connexion à la base de données
 * 
 * La connexion est représenté par l'objet PDO de PHP
 */

class Bd {

    // Attributs
    /**
     * @brief Instance de la classe Bd
     *
     * @var Bd|null
     */
    private static ?Bd $instance = null;

    /**
     * @brief Objet PDO de connexion à la base de données
     *
     * @var PDO|null
     */
    private ?PDO $pdo;

    // Constructeur

    /**
     * @brief Constructeur de la classe Bd
     */
    private function __construct(){
        try {
            $this->pdo = new PDO('mysql:host='. DB_HOST . ';dbname='. DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){

            die('Connexion à la base de données échouée : ' . $e->getMessage());
        }
    }

    // Getters

    /**
     * @brief Retourne l'instance de la classe Bd
     *
     * @return Bd
     */
    public static function getInstance(): Bd{
        if (self::$instance == null){
            self::$instance = new Bd();
        }
        return self::$instance;
    }

    /**
     * @brief Retourne l'objet PDO de connexion à la base de données
     *
     * @return PDO
     */
    public function getConnexion(): PDO{
        return $this->pdo;
    }

    // Empecher de cloner l'objet

    /**
     * @brief Empêche le clonage de l'objet
     *
     * @return void
     */
    private function __clone(){

    }

    // Empecher la deserialisation de l'objet

    /**
     * @brief Empêche la désérialisation de l'objet
     *
     * @return void
     */
    public function __wakeup(){
        throw new Exception("Un singleton ne doit pas être deserialisé");
    }

}