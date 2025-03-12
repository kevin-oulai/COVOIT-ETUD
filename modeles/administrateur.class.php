<?php
/**
* @file    administrateur.class.php
* @author  Kevin Oulai

* @brief   Classe Administrateur pour représenter les utilisateurs ayant le rôle d'administateur.
*
* @details Cette classe permet de gérer les informations d'un administateur, telles que 
* le numero (identifiant) et l'adresse mail.
*          
* @version 0.1
* @date    10/03/2025
*/

class Administrateur {
    
    // Attributs
    /**
     * @brief Numéro de l'administrateur.
     * @var integer|null
     */
    private int|null $numero;
    /**
     * @brief Mail de l'administrateur.
     * @var string|null
     */
    private string|null $adresseMail;

    // Constructeur
    /**
     * @brief Constructeur de la classe badge.
     *
     * @param integer|null $pNumero Numéro de l'administrateur.
     * @param string|null $pMail Mail de l'administrateur.
     */
    public function __construct(?int $pNumero=null, ?string $pAdresseMail=null) {
        $this -> setNumero($pNumero);
        $this -> setAdresseMail($pAdresseMail);
    }

    // Getters & Setters
        // Getters
    /**
     * @brief Retourne le numéro de l'administrateur.
     * @return integer|null
     */
    public function getNumero(): ?int {
        if($this->numero){
            return $this->numero;
        }
        else{
            $pdo = Bd::getInstance()->getConnexion();
            $query = "SELECT numero FROM ADMINISTRATEUR WHERE adresseMail = '". $this->getAdresseMail() ."'";
            $pdoStatement = $pdo->prepare($query);
            $pdoStatement->execute();
            $result = $pdoStatement->fetch(PDO::FETCH_NUM);
            return $result[0];
        }
    }
    /**
     * @brief Retourne le mail de l'administrateur.
     * @return string|null
     */
    public function getAdresseMail(): ?string {
        return $this -> adresseMail;
    }
        // Setters
    /**
     * @brief Assigne un numéro a l'administateur.
     * @param integer|null $pNumero
     * @return void
     */
    public function setNumero(?int $pNumero): void {
        $this -> numero = $pNumero;
    }
    /**
     * @brief Assigne un mail a l'administrateur.
     * @param string|null $pAdresseMail
     * @return void
     */
    public function setAdresseMail(?string $pAdresseMail): void {
        $this -> adresseMail = $pAdresseMail;
    }

    function log(?string $password): bool{
        $pdo = Bd::getInstance()->getConnexion();
        $query = "SELECT motDePasse FROM ADMINISTRATEUR WHERE adresseMail = '". $this->getAdresseMail() ."'";
        $pdoStatement = $pdo->prepare($query);
        $pdoStatement->execute();
        $result = $pdoStatement->fetch(PDO::FETCH_NUM);
        if(!empty($result)) {
            return password_verify($_POST['pwd'], $result[0]);
        }
        return false;
    }
}