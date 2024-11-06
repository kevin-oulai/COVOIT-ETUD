<?php

class Lieu {
    //attributs
    private int $numero;
    private int $numRue;
    private string $nomRue;
    private string $ville;

    //constructeur
    public function __construct(int $numero, int $numRue, string $nomRue, string $ville) {
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