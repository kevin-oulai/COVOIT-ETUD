<?php

class Voiture {

    // Attributs
    private int $numero;
    private string|null $nom;
    private string|null $marque;
    private int $nombrePlaces;

    // Constructeur
    public function __construct(?int $pNumero, ?string $pNom, ?string $pMarque, ?int $pNombrePlaces) {
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
    public function getNombrePlaces(): ?int {
        return $this -> nombrePlaces;
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
    public function setNombrePlaces($pNombrePlaces): void {
        $this -> nombrePlaces = $pNombrePlaces;
    }
}