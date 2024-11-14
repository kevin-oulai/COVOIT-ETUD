<?php

class Avis {
    //atrtibuts ​
    private int|null $numero;
    private string|null $message;
    private int|null $note;
    private int|null $numero_concerne; //clé étrangère du conducteur qui reçoit l'avis
    private int|null $numero_commentateur; //clé étrangère du commentateur qui met l'avis
    
    //constructeur
    public function __construct(?int $numero = null, ?string $message = null, ?int $note = null, ?int $numero_concerne = null, ?int $numero_commentateur = null) {
        $this->numero = $numero;
        $this->message = $message;
        $this->note = $note;
        $this->numero_concerne = $numero_concerne;
        $this->numero_commentateur = $numero_commentateur;
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

    public function getNumeroConcerne(): int
    {
        return $this->numero_concerne;
    }

    public function setNumConducteur(int $numero_concerne): void
    {
        $this->numero_concerne = $numero_concerne;
    }

    public function getNumeroCommentateur(): int
    {
        return $this->numero_commentateur;
    }

    public function setNumeroCommentateur(int $numero_commentateur): void
    {
        $this->numero_commentateur = $numero_commentateur;
    }
}