<?php

class Trajet {
    // Attributs
    private int|null $numero;
    private string|null $heureDep;
    private string|null $heureArr;
    private int|null $prix;
    private string|null $dateDep;
    private int|null $nbPlace;
    private int|null $numero_conducteur;

    // Constructeur
    public function __construct(?int $numero = null,?string $heureDep = null,?string $heureArr = null,?int $prix = null,?string $dateDep = null,?int $nbPlace = null,?int $numero_conducteur = null)
    {
        $this->numero = $numero;
        $this->heureDep = $heureDep;
        $this->heureArr = $heureArr;
        $this->prix = $prix;
        $this->dateDep = $dateDep;
        $this->nbPlace = $nbPlace;
        $this->numero_conducteur = $numero_conducteur;
    }

    // Encapsulation
    public function getNumero(): int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    public function getHeureDep(): ?string
    {
        return $this->heureDep;
    }

    public function setHeureDep(?string $heureDep): void
    {
        $this->heureDep = $heureDep;
    }

    public function getHeureArr(): ?string
    {
        return $this->heureArr;
    }

    public function setHeureArr(?string $heureArr): void
    {
        $this->heureArr = $heureArr;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): void
    {
        $this->prix = $prix;
    }

    public function getDateDep(): ?string
    {
        return $this->dateDep;
    }

    public function setDateDep(?string $dateDep): void
    {
        $this->dateDep = $dateDep;
    }

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(?int $nbPlace): void
    {
        $this->nbPlace = $nbPlace;
    }

    public function getNumeroConducteur(): int
    {
        return $this->numero_conducteur;
    }

    public function setNumeroConducteur(int $numero_conducteur): void
    {
        $this->numero_conducteur = $numero_conducteur;
    }


}