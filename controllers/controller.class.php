<?php
/**
 * @file    controller.class.php
 * @author  Kevin OULAI

 * @brief Classe Controller qui sert de patron à tous les autres controleurs
 *
 * @details Cette classe permet de traiter les actions de l'utilisateur, modifier les données du modèle et de la vue
 *
 * La connexion est représenté par l'objet PDO de PHP
 *
 * La vue est représentée par l'objet Twig\Environment
 *
 * @version 0.1
 * @date    11/01/2025
 */
class Controller{
    /**
     * @brief Objet PDO de connexion à la base de données
     *
     * @var PDO
     */
    private PDO $pdo;
    /**
     * @brief Chargement du dossier contenant les templates
     *
     * @var Twig\Loader\FilesystemLoader
     */
    private Twig\Loader\FilesystemLoader $loader;
    /**
     * @brief Chargement de l'environnement Twig
     *
     * @var Twig\Environment
     */
    private Twig\Environment $twig;
    /**
     * @brief Tableau contenant les valeurs passées par la méthode GET
     *
     * @var array|null
     */
    private ?array $get = null;
    /**
     * @brief Tableau contenant les valeurs passées par la méthode POST
     *
     * @var array|null
     */
    private ?array $post = null;

    /**
     * @brief constructeur de la classe Controller.
     *
     * @param Twig\Environment $twig Environnement Twig
     * @param Twig\Loader\FilesystemLoader $loader Dossier contenant les templates
     */
    public function __construct(Twig\Environment $twig, Twig\Loader\FilesystemLoader $loader){
        $db = Bd::getInstance();
        $this->pdo = $db->getConnexion();
        
        $this->loader = $loader;
        $this->twig = $twig;

        if (isset($_GET) && !empty($_GET)) {
            $this->get = $_GET;
        }
        if (isset($_POST) && !empty($_POST)) {
            $this->post = $_POST;
        }
    }

    /**
     * @brief Fonction appelant dans le controleur la méthode passée par parametre
     *
     * @param string $methode Méthode à appeler dans le controleur
     *
     * @return mixed
     */
    public function call(string $methode): mixed{
        if (!method_exists($this, $methode)) {
            throw new Exception("La méthode $methode n'existe pas dans le controller ".__CLASS__);
        }
        return $this->$methode();
    }

    /**
     * @brief Retourne l'objet PDO de connexion à la base de données
     *
     * @return PDO|null
     */
    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    /**
     * @brief Modifie l'objet PDO de connexion à la base de données
     *
     * @param PDO|null $pdo
     * @return void
     */
    public function setPdo(?PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    /**
     * @brief Retourne le dossier contenant les templates
     *
     * @return Twig\Loader\FilesystemLoader
     */
    public function getLoader(): Twig\Loader\FilesystemLoader
    {
        return $this->loader;
    }

    /**
     * @brief Modifie le dossier contenant les templates
     *
     * @param Twig\Loader\FilesystemLoader $loader Nouveau dossier
     * @return void
     */
    public function setLoader(Twig\Loader\FilesystemLoader $loader): void
    {
        $this->loader = $loader;
    }

    /**
     * @brief Retourne l'environnement Twig
     *
     * @return Twig\Environment
     */
    public function getTwig(): Twig\Environment
    {
        return $this->twig;
    }

    /**
     * @brief Modifie l'environnement Twig
     *
     * @param Twig\Environment $twig
     * @return void
     */
    public function setTwig(Twig\Environment $twig): void
    {
        $this->twig = $twig;
    }

    /**
     * @brief Retourne la liste des valeurs passées par la méthode GET
     *
     * @return array|null
     */
    public function getGet(): ?array
    {
        return $this->get;
    }

    /**
     * @brief Modifie la liste des valeurs passées par la méthode GET
     *
     * @param array|null $get
     * @return void
     */
    public function setGet(?array $get): void
    {
        $this->get = $get;
    }

    /**
     * @brief Retourne la liste des valeurs passées par la méthode POST
     *
     * @return array|null
     */
    public function getPost(): ?array
    {
        return $this->post;
    }

    /**
     * @brief Modifie la liste des valeurs passées par la méthode POST
     *
     * @param array|null $post
     * @return void
     */
    public function setPost(?array $post): void
    {
        $this->post = $post;
    }
}