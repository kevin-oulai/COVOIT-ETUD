<?php

class Badge {
    
    // Attributs
    private int|null $numero;
    private string|null $titre;
    private string|null $image;

    // Constructeur
    public function __construct(?int $pNumero=null, ?string $pTitre=null, ?string $pImage=null) {
        $this -> setNumero($pNumero);
        $this -> setTitre($pTitre);
        $this -> setImage($pImage);
    }

    // Getters & Setters
        // Getters
    public function getNumero(): ?int {
        return $this -> numero;
    }
    public function getTitre(): ?string {
        return $this -> titre;
    }
    public function getImage(): ?string {
        return $this -> image;
    }
        // Setters
    public function setNumero($pNumero): void {
        $this -> numero = $pNumero;
    }
    public function setTitre($pTitre): void {
        $this -> titre = $pTitre;
    }
    public function setImage($pImage): void {
        $this -> image = $pImage;
    }
}