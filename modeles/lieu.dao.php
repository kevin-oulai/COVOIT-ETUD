<?php

class LieuDao{
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

    public function find(int $numero): Lieu
    {
        $sql="SELECT * FROM LIEU WHERE numero= :numero";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute(array(":numero"=>$numero));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Lieu');
        $lieu = $pdoStatement->fetch();

        return $lieu;
    }
    public function findAllAssoc(){
        $sql="SELECT * FROM LIEU";
        $pdoStatement = $this->PDO->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $lieu = $pdoStatement->fetchAll();
        return $lieu;
    }

    public function hydrate(array $tableauAssoc): ?Lieu
    {
        $lieu = new Lieu();
        $lieu->setNumero($tableauAssoc['numero']);
        $lieu->setNumRue($tableauAssoc['numRue']);
        $lieu->setNomRue($tableauAssoc['nomRue']);
        $lieu->setVille($tableauAssoc['ville']);
        return $lieu;
    }

    public function hydrateAll($tableau): ?array{
        $lieux = [];
        foreach($tableau as $tableauAssoc){
            $lieu = $this->hydrate($tableauAssoc);
            $lieux[] = $lieu;
        }
        return $lieux;
    }

}
