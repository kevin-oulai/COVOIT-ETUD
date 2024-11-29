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

    public function find(int $numero): Avis
    {
        $sql="SELECT * FROM AVIS WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Avis');
        $avis = $pdoStatement->fetch();

        return $avis;
    }

    public function findConcerne(int $numero_concerne): Avis
    {
        $sql="SELECT * FROM AVIS WHERE numero_concerne= :numero_concerne";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero_concerne"=>$numero_concerne));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Avis');
        $avis = $pdoStatement->fetch();

        return $avis;
    }

    public function findCommentateur(int $numero_commentateur): Avis
    {
        $sql="SELECT * FROM AVIS WHERE numero_commentateur= :numero_commentateur";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero_commentateur"=>$numero_commentateur));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Avis');
        $avis = $pdoStatement->fetch();

        return $avis;
    }

}