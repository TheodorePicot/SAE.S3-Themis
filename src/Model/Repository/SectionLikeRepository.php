<?php


namespace Themis\Model\Repository;


use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\SectionLike;

class SectionLikeRepository
{

    protected function getTableName(): string
    {
        return 'themis."SectionLike"';
    }

    protected function getColumnNames(): array
    {
        return [
            "login",
            "idSectionProposition"
        ];
    }

    protected function build(array $objectArrayFormat): AbstractDataObject
    {
        return new SectionLike($objectArrayFormat["login"], $objectArrayFormat["idSectionProposition"]);
    }

    protected function getOrderColumn(): string
    {
        return "login";
    }

    protected function getPrimaryKey(): string
    {
        return "login";
    }

    public function getNbLikeSection(int $idSectionProposition): int
    {
        $sqlQuery = "SELECT COUNT(*) FROM {$this->getTableName()} WHERE \"idSectionProposition\" =:idSectionProposition";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = ["idSectionProposition" => $idSectionProposition];
        $pdoStatement->execute($values);
        return (int) $pdoStatement->fetch()[0];
    }

    public function votantHasAlreadyLikedForSection(string $login, int $idSectionProposition): bool
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} 
                    WHERE \"login\" = :login
                    AND \"idSectionProposition\" = :idSectionProposition";

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'login' => $login,
            'idSectionProposition' => $idSectionProposition
        );

        $pdoStatement->execute($values);

        return $pdoStatement->rowCount() > 0;
    }

    public function create(SectionLike $like): string
    {
        $sqlQuery = "INSERT INTO {$this->getTableName()} VALUES (:login, :idSectionProposition)";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = $like->tableFormat();
        $pdoStatement->execute($values);
        return "";
    }

    public function delete(string $login, int $idSectionProposition): string
    {
        $sqlQuery = "DELETE  FROM {$this->getTableName()} WHERE \"login\" =:login AND \"idSectionProposition\" =:idSectionProposition";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = array(
            'login' => $login,
            'idSectionProposition' => $idSectionProposition
        );
        $pdoStatement->execute($values);
        return "";
    }

}
