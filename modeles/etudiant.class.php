<?php

class Etudiant {
    //attributs
    private int|null $numero;
    private string|null $nom;
    private string|null $prenom;
    private string|null $dateNaiss;
    private string|null $adresseMail;
    private string|null $numTelephone;
    private int|null $numero_voiture;

    //constructeur
    public function __construct(?int $numero=null, ?string $nom = null, ?string $prenom = null, ?string $dateNaiss = null, ?string $adresseMail = null, ?string $numTelephone = null, ?int $numero_voiture = null) {
        $this->numero = $numero;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaiss = $dateNaiss;
        $this->adresseMail = $adresseMail;
        $this->numTelephone = $numTelephone;
        $this->numero_voiture = $numero_voiture;
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

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getDateNaiss(): string
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(string $dateNaiss): void
    {
        $this->dateNaiss = $dateNaiss;
    }

    public function getAdresseMail(): string
    {
        return $this->adresseMail;
    }

    public function setAdresseMail(string $adresseMail): void
    {
        $this->adresseMail = $adresseMail;
    }

    public function getNumTelephone(): string
    {
        return $this->numTelephone;
    }

    public function setNumTelephone(string $numTelephone): void
    {
        $this->numTelephone = $numTelephone;
    }

    public function getNumeroVoiture(): ?int
    {
        return $this->numero_voiture;
    }

    public function setNumeroVoiture(?int $numero_voiture): void
    {
        $this->numero_voiture = $numero_voiture;
    }
}