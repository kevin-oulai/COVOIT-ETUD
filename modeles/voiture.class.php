<?php

class Voiture {

    // Attributs
    private int|null $numero;
    private string|null $nom;
    private string|null $marque;
    private int|null $nbPlace;

    // Constructeur
    public function __construct(?int $pNumero = null, ?string $pNom = null, ?string $pMarque = null, ?int $pNombrePlaces = null) {
        $this -> setNumero($pNumero);
        $this -> setNom($pNom);
        $this -> setMarque($pMarque);
        $this -> setNombrePlaces($pNombrePlaces);
    }

    // Getters & Setters
        // Getters
    public function getNumero(): ?int {
        return $this -> numero;
    }
    public function getNom(): ?string {
        return $this -> nom;
    }
    public function getMarque(): ?string {
        return $this -> marque;
    }
    public function getNbPlace(): ?int {
        return $this -> nbPlace;
    }

        // Setters
    public function setNumero($pNumero): void {
        $this -> numero = $pNumero;
    }
    public function setNom($pNom): void {
        $this -> nom = $pNom;
    }
    public function setMarque($pMarque): void {
        $this -> marque = $pMarque;
    }
    public function setNbPlace($pNombrePlaces): void {
        $this -> nbPlace = $pNombrePlaces;
    }
}