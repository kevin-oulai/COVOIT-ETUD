<?php
/**
* @file    voiture.class.php
* @author  Thibault ROSALIE

* @brief Classe Voiture pour représenter la voiture d'un étudiant conducteur
* 
* @details Cette classe permet de gérer les informations d'une voiture, telles 
* que son numéro, son nom, sa marque et le nombre de places disponibles.

* @version 0.1
* @date    14/11/2024
*/
class Voiture {

    // Attributs
    /**
     * @brief Numéro de la voiture
     *
     * @var integer|null
     */
    private int|null $numero;
    /**
     * @brief Nom de la voiture
     *
     * @var string|null
     */
    private string|null $modele;
    /**
     * @brief Marque de la voiture
     *
     * @var string|null
     */
    private string|null $marque;
    /**
     * @brief Nombre de places disponibles dans la voiture
     *
     * @var integer|null
     */
    private int|null $nbPlace;

    // Constructeur
    /**
     * @brief Constructeur de la classe Voiture
     *
     * @param integer|null $pNumero
     * @param string|null $pNom
     * @param string|null $pMarque
     * @param integer|null $pNombrePlaces
     */
    public function __construct(?int $pNumero = null, ?string $pModele = null, ?string $pMarque = null, ?int $pNombrePlaces = null) {
        $this -> setNumero($pNumero);
        $this -> setModele($pModele);
        $this -> setMarque($pMarque);
        $this -> setNbPlace($pNombrePlaces);
    }

    // Getters & Setters
        // Getters
    /**
     * @brief Retourne le numéro de la voiture
     *
     * @return integer|null
     */
    public function getNumero(): ?int {
        return $this -> numero;
    }

    /**
     * @brief Retourne le nom de la voiture
     *
     * @return string|null
     */
    public function getModele(): ?string {
        return $this -> modele;
    }

    /**
     * @brief Retourne la marque de la voiture
     *
     * @return string|null
     */
    public function getMarque(): ?string {
        return $this -> marque;
    }

    /**
     * @brief Retourne le nombre de places disponibles dans la voiture
     *
     * @return integer|null
     */
    public function getNbPlace(): ?int {
        return $this -> nbPlace;
    }

        // Setters
    /**
     * @brief Assigne un numéro à la voiture
     *
     * @param int $pNumero
     * @return void
     */
    public function setNumero($pNumero): void {
        $this -> numero = $pNumero;
    }

    /**
     * @brief Assigne un nom à la voiture
     *
     * @param string $pNom
     * @return void
     */
    public function setModele($pModele): void {
        $this -> modele = $pModele;
    }

    /**
     * @brief Assigne une marque à la voiture
     *
     * @param string $pMarque
     * @return void
     */
    public function setMarque($pMarque): void {
        $this -> marque = $pMarque;
    }

    /**
     * @brief Assigne un nombre de places disponibles dans la voiture
     *
     * @param int $pNombrePlaces
     * @return void
     */
    public function setNbPlace($pNombrePlaces): void {
        $this -> nbPlace = $pNombrePlaces;
    }
}