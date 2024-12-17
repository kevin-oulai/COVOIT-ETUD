<?php
/**
* @file    avis.class.php
* @author  Candice Dutournier

* @brief   Classe Avis pour représenter l'avis d'un étudiant passager.
*
* @details Cette classe permet de gérer les informations d'un avis, telles que 
* le numero (identifiant), le message, la note, l'image, le numéro de l'étudiant concerné par l'avis
* et le numéro du commentateur de l'avis.
* 
* Les étudiants concernés et commentateurs sont représentés par
* un objet Etudiant.
*          
* @version 0.1
* @date    14/11/2024
*/

class Avis {
    //atrtibuts
    /**
     * @brief Numero de l'avis.
     * @var integer|null
     */
    private int|null $numero;
    /**
     * @brief Date de post de l'avis.
     * @var string|null
     */
    private string|null $datePost;
    /**
     * @brief Message de l'avis.
     * @var string|null
     */
    private string|null $message;
    /**
     * @brief Note de l'avis.
     * @var integer|null
     */
    private int|null $note;
    /**
     * @brief Numéro de l'étudiant concerné par l'avis.
     * @var integer|null clé étrangère du conducteur qui reçoit l'avis.
     */
    private int|null $numero_concerne; 
    /**
     * @brief Numéro de l'étudiant qui met l'avis.
     * @var integer|null clé étrangère du passager qui met l'avis.
     */
    private int|null $numero_commentateur;
    
    //constructeur
    /**
     * @brief constructeur de la classe Avis.
     *
     * @param integer|null $numero Identifiant de l'avis.
     * @param string|null $datePost Date de post de l'avis.
     * @param string|null $message Message de l'avis.
     * @param integer|null $note Note de l'avis
     * @param integer|null $numero_concerne Numéro de l'étudiant concerné par l'avis.
     * @param integer|null $numero_commentateur Numéro de l'étudiant qui met l'avis.
     */
    public function __construct(?int $numero = null,?string $datePost = null, ?string $message = null, ?int $note = null, ?int $numero_concerne = null, ?int $numero_commentateur = null) {
        $this->numero = $numero;
        $this->datePost = $datePost;
        $this->message = $message;
        $this->note = $note;
        $this->numero_concerne = $numero_concerne;
        $this->numero_commentateur = $numero_commentateur;
    }

    //getters & setters
    /**
     * @brief Retourne le numéro de l'avis.
     * @return integer|null
     */
    public function getNumero(): ?int
    {
        return $this->numero;
    }

    /**
     * @brief Assigne un numéro à l'avis
     * @param integer|null $numero
     * @return void
     */
    public function setNumero(?int $numero): void
    {
        $this->numero = $numero;
    }
    /**
     * @brief Retourne la date de l'avis.
     * @return string|null
     */
    public function getDatePost(): ?string
    {
        return $this->datePost;
    }

    /**
     * @brief Assigne une date à l'avis
     * @param string|null $dateDep
     * @return void
     */
    public function setDateDep(?string $dateDep): void
    {
        $this->datePost = $dateDep;
    }

    /**
     * @brief Retourne le message de l'avis.
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @brief Assigne un message à l'avis
     * @param string|null $message
     * @return void
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @brief Retourne la note de l'avis.
     * @return integer|null
     */
    public function getNote(): ?int
    {
        return $this->note;
    }

    /**
     * @brief Assigne une note à l'avis
     * @param integer|null $note
     * @return void
     */
    public function setNote(?int $note): void
    {
        $this->note = $note;
    }

    /**
     * @brief Retourne le numéro de l'étudiant concerné par l'avis.
     * @return integer|null
     */
    public function getNumeroConcerne(): ?int
    {
        return $this->numero_concerne;
    }


    /**
     * @brief Assigne un numéro d'étudiant au numéro du concerné de l'avis.
     * @param integer|null $numero_concerne
     * @return void
     */
    public function setNumeroConcerne(?int $numero_concerne): void
    {
        $this->numero_concerne = $numero_concerne;
    }

    
    /**
     * @brief Retourne le numéro du commentateur de l'avis.
     * @return integer|null
     */
    public function getNumeroCommentateur(): ?int
    {
        return $this->numero_commentateur;
    }


    /**
     * @brief Assigne un numéro d'étudiant au numéro du commentateur de l'avis.
     * @param integer|null $numero_commentateur
     * @return void
     */
    public function setNumeroCommentateur(?int $numero_commentateur): void
    {
        $this->numero_commentateur = $numero_commentateur;
    }
}