<?php

class Lieu {
    //attributs
    private int|null $numero;
    private int|null $numRue;
    private string|null $nomRue;
    private string|null $ville;

    //constructeur
    public function __construct(?int $numero = null, ?int $numRue = null, ?string $nomRue = null, ?string $ville = null) {
        $this->numero = $numero;
        $this->numRue = $numRue;
        $this->nomRue = $nomRue;
        $this->ville = $ville;
    }

    //getters & setters
    public function getNumero(): int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    public function getNumRue(): int
    {
        return $this->numRue;
    }

    public function setNumRue(int $numRue): void
    {
        $this->numRue = $numRue;
    }

    public function getNomRue(): string
    {
        return $this->nomRue;
    }

    public function setNomRue(string $nomRue): void
    {
        $this->nomRue = $nomRue;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }
}