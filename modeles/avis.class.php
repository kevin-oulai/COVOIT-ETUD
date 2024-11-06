<?php

class Avis {
    //atrtibuts ​
    private int $numero;
    private string|null $message;
    private int $note;
    private int $num_conducteur; //clé étrangère du conducteur qui reçoit l'avis
    private int $num_passager; //clé étrangère du commentateur qui met l'avis
    
    //constructeur
    public function __construct(int $numero, ?string $message, int $note, int $num_conducteur, int $num_passager) {
        $this->numero = $numero;
        $this->message = $message;
        $this->note = $note;
        $this->num_conducteur = $num_conducteur;
        $this->num_passager = $num_passager;
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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function getNote(): int
    {
        return $this->note;
    }

    public function setNote(int $note): void
    {
        $this->note = $note;
    }

    public function getNumConducteur(): int
    {
        return $this->num_conducteur;
    }

    public function setNumConducteur(int $num_conducteur): void
    {
        $this->num_conducteur = $num_conducteur;
    }

    public function getNumPassager(): int
    {
        return $this->num_passager;
    }

    public function setNumPassager(int $num_passager): void
    {
        $this->num_passager = $num_passager;
    }
}