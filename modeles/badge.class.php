<?php

/**
 * @file    badge.class.php
 * @author  Candice Dutournier

 * @brief   Classe Badge pour représenter les badges que peut recevoir un étudiant.
 *
 * @details Cette classe permet de gérer les informations d'un badge, telles que 
 * le numero (identifiant), le titre et l'image du badge.
 *          
 * @version 0.1
 * @date    14/11/2024
 */

class Badge
{

    // Attributs Badge(numero, titre, image, description, categorie, rang)
    /**
     * @brief Numéro du badge.
     * @var integer|null
     */
    private int|null $numero;
    /**
     * @brief Titre du badge.
     * @var string|null
     */
    private string|null $titre;
    /**
     * @brief URL de l'image du badge
     * @var string|null
     */
    private string|null $image;
    /**
     * @brief Description du badge.
     * @var string|null
     */
    private string|null $description;
    /**
     * @brief Catégorie du badge.
     * @var string|null
     */
    private string|null $categorie;
    /**
     * @brief Rang du badge.
     * @var string|null
     */
    private string|null $rang;

    // Constructeur
    /**
     * @brief Constructeur de la classe badge.
     *
     * @param integer|null $pNumero Numéro du badge.
     * @param string|null $pTitre Titre du badge.
     * @param string|null $pImage URL de l'image du badge.
     */
    public function __construct(?int $pNumero = null, ?string $pTitre = null, ?string $pImage = null, ?string $pDescription = null, ?string $pCategorie = null, ?string $pRang = null)
    {
        $this->setNumero($pNumero);
        $this->setTitre($pTitre);
        $this->setImage($pImage);
        $this->setDescription($pDescription);
        $this->setCategorie($pCategorie);
        $this->setRang($pRang);
    }

    // Getters & Setters
    // Getters
    /**
     * @brief Retourne le numéro du badge.
     * @return integer|null
     */
    public function getNumero(): ?int
    {
        return $this->numero;
    }
    /**
     * @brief Retourne le titre du badge.
     * @return string|null
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }
    /**
     * @brief Retourne l'URL de l'image du badge.
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
    /**
     * @brief Retourne la description du badge.
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
    /**
     * @brief Retourne la catégorie du badge.
     * @return string|null
     */
    public function getCategorie(): ?string
    {
        return $this->categorie;
    }
    /**
     * @brief Retourne le rang du badge.
     * @return string|null
     */
    public function getRang(): ?string
    {
        return $this->rang;
    }

    // Setters
    /**
     * @brief Assigne un numéro au badge.
     * @param integer|null $pNumero
     * @return void
     */
    public function setNumero(?int $pNumero): void
    {
        $this->numero = $pNumero;
    }
    /**
     * @brief Assigne un titre au badge.
     * @param string|null $pTitre
     * @return void
     */
    public function setTitre(?string $pTitre): void
    {
        $this->titre = $pTitre;
    }
    /**
     * @brief Assigne une URL d'image au badge.
     * @param string|null $pImage
     * @return void
     */
    public function setImage(?string $pImage): void
    {
        $this->image = $pImage;
    }
    /**
     * @brief Assigne une description au badge.
     * @param string|null $pDescription
     * @return void
     */
    public function setDescription(?string $pDescription): void
    {
        $this->description = $pDescription;
    }
    /**
     * @brief Assigne une catégorie au badge.
     * @param string|null $pCategorie
     * @return void
     */
    public function setCategorie(?string $pCategorie): void
    {
        $this->categorie = $pCategorie;
    }
    /**
     * @brief Assigne un rang au badge.
     * @param string|null $pRang
     * @return void
     */
    public function setRang(?string $pRang): void
    {
        $this->rang = $pRang;
    }
}
