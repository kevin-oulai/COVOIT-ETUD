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
    /**
     *
     * @return integer
     */
    public function getNumero(): int
    {
        return $this->numero;
    }

    /**
     *
     * @param integer $numero
     * @return void
     */
    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    /**
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     *
     * @param string|null $message
     * @return void
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     *
     * @return integer
     */
    public function getNote(): int
    {
        return $this->note;
    }

    /**
     *
     * @param integer $note
     * @return void
     */
    public function setNote(int $note): void
    {
        $this->note = $note;
    }

    /**
     *
     * @return integer
     */
    public function getNumeroConcerne(): int
    {
        return $this->numero_concerne;
    }


    /**
     *
     * @param integer $numero_concerne
     * @return void
     */
    public function setNumeroConcerne(int $numero_concerne): void
    {
        $this->numero_concerne = $numero_concerne;
    }

    
    /**
     *
     * @return integer
     */
    public function getNumeroCommentateur(): int
    {
        return $this->numero_commentateur;
    }


    /**
     *
     * @param integer $numero_commentateur
     * @return void
     */
    public function setNumeroCommentateur(int $numero_commentateur): void
    {
        $this->numero_commentateur = $numero_commentateur;
    }
}