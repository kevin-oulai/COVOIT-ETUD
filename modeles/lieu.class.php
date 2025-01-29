<?php
/**
* @file    lieu.class.php
* @author  Thibault ROSALIE

* @brief Classe Lieu pour représenter un lieu de départ ou d'arrivée
* 
* @details Cette classe permet de gérer les informations d'un lieu, telles 
* que son numéro, son numéro de rue, son nom de rue et sa ville.

* @version 0.1
* @date    14/11/2024
*/
class Lieu {
    // Attributs
    /**
     * @brief Numéro du lieu
     *
     * @var integer|null
     */
    private int|null $numero;

    /**
     * @brief Numéro de rue du lieu
     *
     * @var integer|null
     */
    private int|null $numRue;

    /**
     * @brief Nom de rue du lieu
     *
     * @var string|null
     */
    private string|null $nomRue;

    /**
     * @brief Ville du lieu
     *
     * @var string|null
     */
    private string|null $ville;

    //constructeur
    /**
     * @brief Constructeur de la classe Lieu
     * 
     * @param integer|null $numero
     * @param integer|null $numRue
     * @param string|null $nomRue
     * @param string|null $ville
     */
    public function __construct(?int $numero, ?int $numRue, ?string $nomRue, ?string $ville) {
        $this->setNumero($numero);
        $this->setNumRue($numRue);
        $this->setNomRue($nomRue);
        $this->setVille($ville);
    }

    // Getters & Setters
        // Getters
    /**
     * @brief Retourne le numéro du lieu
     *
     * @return integer
     */
    public function getNumero(): int
    {
        return $this->numero;
    }

    /**
     * @brief Retourne le numéro de rue du lieu
     *
     * @return integer
     */
    public function getNumRue(): int
    {
        return $this->numRue;
    }
    
    /**
     * @brief Retourne le nom de rue du lieu
     *
     * @return string
     */
    public function getNomRue(): string
    {
        return $this->nomRue;
    }
    
    /**
     * @brief Retourne la ville du lieu
     *
     * @return string
     */
    public function getVille(): string
    {
        return $this->ville;
    }
    
        // Setters
    /**
     * @brief Assigne un numéro au lieu
     *
     * @param integer $numero
     * @return void
     */
    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @brief Assigne un numéro de rue au lieu
     *
     * @param integer $numRue
     * @return void
     */
    public function setNumRue(int $numRue): void
    {
        $this->numRue = $numRue;
    }

    /**
     * @brief Assigne un nom de rue au lieu
     *
     * @param string $nomRue
     * @return void
     */
    public function setNomRue(string $nomRue): void
    {
        $this->nomRue = $nomRue;
    }

    /**
     * @brief Assigne une ville au lieu
     *
     * @param string $ville
     * @return void
     */
    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }
}