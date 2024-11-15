<?php

/**
 * @brief Classe Trajet pour représenter un trajet entre deux lieux
 * 
 * @details Cette classe permet de gérer les informations d'un trajet, telles 
 * que son numéro, son heure de départ, son heure d'arrivée, son prix, sa date de départ, 
 * le nombre de places disponibles et le numéro du conducteur.
 */

class Trajet {
    // Attributs
    /**
     * @brief Numéro du trajet
     *
     * @var integer|null
     */
    private int|null $numero;

    /**
     * @brief Heure de départ du trajet
     *
     * @var string|null
     */
    private string|null $heureDep;

    /**
     * @brief Heure d'arrivée du trajet
     *
     * @var string|null
     */
    private string|null $heureArr;

    /**
     * @brief Prix du trajet
     *
     * @var integer|null
     */
    private int|null $prix;

    /**
     * @brief Date de départ du trajet
     *
     * @var string|null
     */
    private string|null $dateDep;

    /**
     * @brief Nombre de places disponibles dans le trajet
     *
     * @var integer|null
     */
    private int|null $nbPlace;

    /**
     * @brief Numéro du conducteur du trajet
     *
     * @var integer|null
     */
    private int|null $numero_conducteur;

    // Constructeur
    /**
     * @brief Constructeur de la classe Trajet
     *
     * @param integer|null $numero
     * @param string|null $heureDep
     * @param string|null $heureArr
     * @param integer|null $prix
     * @param string|null $dateDep
     * @param integer|null $nbPlace
     * @param integer|null $numero_conducteur
     */
    public function __construct(?int $numero = null,?string $heureDep = null,?string $heureArr = null,?int $prix = null,?string $dateDep = null,?int $nbPlace = null,?int $numero_conducteur = null)
    {
        $this->setNumero($numero);
        $this->setHeureDep($heureDep);
        $this->setHeureArr($heureArr);
        $this->setPrix($prix);
        $this->setDateDep($dateDep);
        $this->setNbPlace($nbPlace);
        $this->setNumeroConducteur($numero_conducteur);
    }

    // Getters et Setters
        // Getters
    /**
     * @brief Retourne le numéro du trajet
     *
     * @return integer|null
     */
    public function getNumero(): int
    {
        return $this->numero;
    }

    /**
     * @brief Retourne l'heure de départ du trajet
     *
     * @return string|null
     */
    public function getHeureDep(): ?string
    {
        return $this->heureDep;
    }

    /**
     * @brief Retourne l'heure d'arrivée du trajet
     *
     * @return string|null
     */
    public function getHeureArr(): ?string
    {
        return $this->heureArr;
    }

    /**
     * @brief Retourne le prix du trajet
     *
     * @return integer|null
     */
    public function getPrix(): ?int
    {
        return $this->prix;
    }

    /**
     * @brief Retourne la date de départ du trajet
     *
     * @return string|null
     */
    public function getDateDep(): ?string
    {
        return $this->dateDep;
    }

    /**
     * @brief Retourne le nombre de places disponibles dans le trajet
     *
     * @return integer|null
     */
    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    /**
     * @brief Retourne le numéro du conducteur du trajet
     *
     * @return integer|null
     */
    public function getNumeroConducteur(): int
    {
        return $this->numero_conducteur;
    }

        // Setters
    /**
     * @brief Assigne un numéro au trajet
     *
     * @param integer $numero
     * @return void
     */
    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @brief Assigne une heure de départ au trajet
     *
     * @param string|null $heureDep
     * @return void
     */
    public function setHeureDep(?string $heureDep): void
    {
        $this->heureDep = $heureDep;
    }

    /**
     * @brief Assigne une heure d'arrivée au trajet
     *
     * @param string|null $heureArr
     * @return void
     */
    public function setHeureArr(?string $heureArr): void
    {
        $this->heureArr = $heureArr;
    }

    /**
     * @brief Assigne un prix au trajet
     *
     * @param integer|null $prix
     * @return void
     */
    public function setPrix(?int $prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @brief Assigne une date de départ au trajet
     *
     * @param string|null $dateDep
     * @return void
     */
    public function setDateDep(?string $dateDep): void
    {
        $this->dateDep = $dateDep;
    }

    /**
     * @brief Assigne un nombre de places disponibles au trajet
     *
     * @param integer|null $nbPlace
     * @return void
     */
    public function setNbPlace(?int $nbPlace): void
    {
        $this->nbPlace = $nbPlace;
    }

    /**
     * @brief Assigne un numéro de conducteur au trajet
     *
     * @param integer|null $numero_conducteur
     * @return void
     */
    public function setNumeroConducteur(int $numero_conducteur): void
    {
        $this->numero_conducteur = $numero_conducteur;
    }
}