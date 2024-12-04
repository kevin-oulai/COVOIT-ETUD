<?php
class BadgeDao{
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

    public function find(int $numeroEtudiant): ?Badge
    {
        $sql="SELECT * FROM BADGE B JOIN OBTENIR O ON B.NUMERO = O.NUMERO_BADGE WHERE numero_etudiant= :numeroEtudiant";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numeroEtudiant"=>$numeroEtudiant));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Badge');
        $badge = $pdoStatement->fetch();

        return $badge;
    }

}