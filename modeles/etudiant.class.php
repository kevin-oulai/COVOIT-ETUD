<?php

class Etudiant {
    //attributs
    private int $numero;
    private string|null $nom;
    private string|null $prenom;
    private string|null $dateNaiss;
    private string|null $mail;
    private string|null $tel;
    private int|null $num_voiture;

    //constructeur
    public function __construct(int $numero, ?string $nom = null, ?string $prenom = null, ?string $dateNaiss = null, ?string $mail = null, ?string $tel = null, ?int $num_voiture = null) {
        $this->numero = $numero;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaiss = $dateNaiss;
        $this->mail = $mail;
        $this->tel = $tel;
        $this->num_voiture = $num_voiture;
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

    public function getMail(): string
    {
        return $this->mail;
    }

    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    public function getTel(): string
    {
        return $this->tel;
    }

    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }

    public function getNumVoiture(): ?int
    {
        return $this->num_voiture;
    }

    public function setNumVoiture(?int $num_voiture): void
    {
        $this->num_voiture = $num_voiture;
    }
}