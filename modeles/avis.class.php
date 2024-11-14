<?php

class Avis {
    //atrtibuts 
    /**
     *
     * @var integer
     */
    private int $numero;
    /**
     *
     * @var string|null
     */
    private string|null $message;
    /**
     *
     * @var integer
     */
    private int $note;
    /**
     *
     * @var integer
     */
    private int $num_conducteur; //clé étrangère du conducteur qui reçoit l'avis
    /**
     *
     * @var integer
     */
    private int $num_passager; //clé étrangère du commentateur qui met l'avis
    
    //constructeur
    /**
     *
     * @param integer $numero
     * @param string|null $message
     * @param integer $note
     * @param integer $num_conducteur
     * @param integer $num_passager
     */
    public function __construct(int $numero, ?string $message, int $note, int $num_conducteur, int $num_passager) {
        $this->numero = $numero;
        $this->message = $message;
        $this->note = $note;
        $this->num_conducteur = $num_conducteur;
        $this->num_passager = $num_passager;
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
    public function getNumConducteur(): int
    {
        return $this->num_conducteur;
    }

    /**
     *
     * @param integer $num_conducteur
     * @return void
     */
    public function setNumConducteur(int $num_conducteur): void
    {
        $this->num_conducteur = $num_conducteur;
    }

    /**
     *
     * @return integer
     */
    public function getNumPassager(): int
    {
        return $this->num_passager;
    }

    /**
     *
     * @param integer $num_passager
     * @return void
     */
    public function setNumPassager(int $num_passager): void
    {
        $this->num_passager = $num_passager;
    }
}