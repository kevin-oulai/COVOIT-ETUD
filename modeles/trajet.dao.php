<?php

class TrajetDao{
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

    public function find(int $numero): Trajet
    {
        $sql="SELECT * FROM TRAJET WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Trajet');
        $trajet = $pdoStatement->fetch();

        return $trajet;
    }

}