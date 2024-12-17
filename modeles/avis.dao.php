<?php

class AvisDao{
    private ?PDO $PDO;

    public function __construct(?PDO $pdo = null)
    {
        $this->PDO = $pdo;
    }

    public function getPDO(): ?PDO
    {
        return $this->PDO;
    }

    public function setPDO(?PDO $PDO): void
    {
        $this->PDO = $PDO;
    }

    public function find(?int $numero): ?Avis
    {
        $sql="SELECT * FROM AVIS WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Avis');
        $avis = $pdoStatement->fetch();

        return $avis;
    }

    public function findAllConcerne(?int $numero_concerne): array
    {
        $requete = "SELECT A.*, E.nom as nomEtudiant, E.prenom as prenomEtudiant from AVIS A join ETUDIANT E on A.numero_commentateur = E.numero WHERE numero_concerne= :numero_concerne";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->bindValue(1, PDO::PARAM_STR);
        $pdoStatement->execute(array(":numero_concerne"=>$numero_concerne));
        $listeAvisConcerne = $pdoStatement->fetchAll();
        return $listeAvisConcerne;
    }

    public function findAllCommentateur(?int $numero_commentateur): array
    {
        $requete = "SELECT A.*, E.nom as nomEtudiant, E.prenom as prenomEtudiant from AVIS A join ETUDIANT E on A.numero_concerne = E.numero WHERE numero_commentateur= :numero_commentateur";
        $pdoStatement = $this->PDO->prepare($requete);
        $pdoStatement->bindValue(1, PDO::PARAM_STR);
        $pdoStatement->execute(array(":numero_commentateur"=>$numero_commentateur));
        $listeAvisCommentateur = $pdoStatement->fetchAll();
        return $listeAvisCommentateur;
    }

    public function findConcerne(?int $numero_concerne): ?Avis
    {
        $sql="SELECT * FROM AVIS WHERE numero_concerne= :numero_concerne";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero_concerne"=>$numero_concerne));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Avis');
        $avis = $pdoStatement->fetch();

        return $avis;
    }

    public function findCommentateur(?int $numero_commentateur): ?Avis
    {
        $sql="SELECT * FROM AVIS WHERE numero_commentateur= :numero_commentateur";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero_commentateur"=>$numero_commentateur));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Avis');
        $avis = $pdoStatement->fetch();

        return $avis;
    }

}