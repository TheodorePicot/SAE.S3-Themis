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
            "idSection"
        ];
    }

    protected function build(array $objectArrayFormat): AbstractDataObject
    {
        return new SectionLike($objectArrayFormat["login"], $objectArrayFormat["idSection"]);
    }

    protected function getOrderColumn(): string
    {
        return "login";
    }

    protected function getPrimaryKey(): string
    {
        return "login";
    }

    public function getNbLikeSection(int $idSection): int
    {
        $sqlQuery = "SELECT COUNT(*) FROM {$this->getTableName()} WHERE \"idSection\" =:idSection";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = ["idSection" => $idSection];
        $pdoStatement->execute($values);
        return (int) $pdoStatement->fetch()[0];
    }

    public function votantHasAlreadyLikedForSection(string $login, int $idSection): bool
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} 
                    WHERE \"login\" = :login
                    AND \"idSection\" = :idSection";

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'login' => $login,
            'idSection' => $idSection
        );

        $pdoStatement->execute($values);

        return $pdoStatement->rowCount() > 0;
    }

    public function create(SectionLike $like): string
    {
        $sqlQuery = "INSERT INTO {$this->getTableName()} VALUES (:login, :idSection)";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = $like->tableFormat();
        $pdoStatement->execute($values);
        return "";
    }

    public function delete(string $login, int $idSection): string
    {
        $sqlQuery = "DELETE  FROM {$this->getTableName()} WHERE \"login\" =:login AND \"idSection\" =:idSection";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = array(
            'login' => $login,
            'idSection' => $idSection
        );
        $pdoStatement->execute($values);
        return "";
    }

}
