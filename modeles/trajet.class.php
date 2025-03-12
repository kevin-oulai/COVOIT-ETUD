<?php
/**
* @file    trajet.class.php
* @author  Thibault ROSALIE

 * @brief Classe Trajet pour représenter un trajet entre deux lieux
 * 
 * @details Cette classe permet de gérer les informations d'un trajet, telles 
 * que son numéro, son heure de départ, son heure d'arrivée, son prix, sa date de départ, 
 * le nombre de places disponibles et le numéro du conducteur.

* @version 0.1
* @date    14/11/2024
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
     * @var float|null
     */
    private float|null $prix;

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

    private int|null $numero_lieu_depart;
    private int|null $numero_lieu_arrivee;

    // Constructeur
    /**
     * @brief Constructeur de la classe Trajet
     *
     * @param integer|null $numero
     * @param string|null $heureDep
     * @param string|null $heureArr
     * @param float|null $prix
     * @param string|null $dateDep
     * @param integer|null $nbPlace
     * @param integer|null $numero_conducteur
     */

    public function __construct(?int $numero = null,?string $heureDep = null,?string $heureArr = null,?float $prix = null,?string $dateDep = null,?int $nbPlace = null,?int $numero_conducteur = null, ?int $numero_lieu_depart = null, ?int $numero_lieu_arrivee = null)
    {
        $this->setNumero($numero);
        $this->setHeureDep($heureDep);
        $this->setHeureArr($heureArr);
        $this->setPrix($prix);
        $this->setDateDep($dateDep);
        $this->setNbPlace($nbPlace);
        $this->setNumeroConducteur($numero_conducteur);
        $this->setNumeroLieuDepart($numero_lieu_depart);
        $this->setNumeroLieuArrivee($numero_lieu_arrivee);
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
     * @return float|null
     */
    public function getPrix(): ?float
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
     * @param float|null $prix
     * @return void
     */
    public function setPrix(?float $prix): void
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
    /**
     * @brief Renvoie le numéro du lieu de départ
     *
     * @return integer|null
     */
    public function getNumeroLieuDepart(): ?int
    {
        return $this->numero_lieu_depart;
    }
    /**
     * @brief Assigne un numéro pour un lieu de départ
     *
     * @param integer|null $numero_lieu_depart
     * @return void
     */
    public function setNumeroLieuDepart(?int $numero_lieu_depart): void
    {
        $this->numero_lieu_depart = $numero_lieu_depart;
    }
    /**
     * @brief Renvoie un numéro de lieu d'arrivé
     *
     * @return integer|null
     */
    public function getNumeroLieuArrivee(): ?int
    {
        return $this->numero_lieu_arrivee;
    }
    /**
     * @brief Assigne un numéro de lieu d'arrivé
     *
     * @param integer|null $numero_lieu_arrivee
     * @return void
     */
    public function setNumeroLieuArrivee(?int $numero_lieu_arrivee): void
    {
        $this->numero_lieu_arrivee = $numero_lieu_arrivee;
    }
}