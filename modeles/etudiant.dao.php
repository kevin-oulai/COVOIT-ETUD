<?php
class EtudiantDao
{
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

    public function find(int $numero): Etudiant
    {
        $sql="SELECT * FROM ETUDIANT WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Etudiant');
        $etudiant = $pdoStatement->fetch();

        return $etudiant;
    }

}
