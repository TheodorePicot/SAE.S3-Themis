<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\Proposition;

class PropositionRepository extends AbstractRepository
{
    /**
     * Permet d'obtenir une liste de toute les propositions d'une question en fonction d'un $idQuestion
     *
     * @param int $idQuestion
     * @return array
     */
    public function selectByQuestion(int $idQuestion): array
    {
        $sqlQuery = 'SELECT * FROM "Propositions" WHERE "idQuestion" =:idQuestion';

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = [
            "idQuestion" => $idQuestion
        ];

        $pdoStatement->execute($values);

        $propositions = array();
        foreach ($pdoStatement as $proposition) {
            $propositions[] = $this->build($proposition);
        }

        return $propositions;
    }

    /**
     * Permet d'obtenir une liste de toute les propositions écrite par l'utilisateur qui possède le $login en paramètre
     *
     * @param string $login
     * @return array
     */
    public function selectAllByUser(string $login): array
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE " . '"loginAuteur" = ?';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array($login));

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    /**
     * Permet d'obtenir une liste de toute les propositions d'une question ordoné en fonction de leur résultat dans le
     * scrutin uninominal
     *
     * @param int $idQuestion
     * @return array
     */
    public function selectAllByQuestionsOrderedByVoteValueScrutin(int $idQuestion): array
    {
        $sqlQuery = "SELECT \"idProposition\" FROM themis.\"ScrutinUninominal\" WHERE \"idQuestion\" =:idQuestion GROUP BY \"idProposition\" ORDER BY COUNT(*) DESC";

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = [
            "idQuestion" => $idQuestion
        ];

        $pdoStatement->execute($values);

        $propositions = array();
        foreach ($pdoStatement as $proposition) {
            $propositions[] = $this->select($proposition[0]);
        }

        return $propositions;
    }

    /**
     * Permet de vérifier si une proposition apartient à l'idQuestion placé en paramètre
     *
     * @param int $idQuestion
     * @return bool
     */
    public function aPropositionIsInQuestion(int $idQuestion): bool
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()}" . ' WHERE "idQuestion" =:idQuestion';

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = [
            "idQuestion" => $idQuestion
        ];

        $pdoStatement->execute($values);
        return $pdoStatement->rowCount() > 0;
    }

    /**
     * @inheritDoc
     */
    public function build(array $objectArrayFormat): Proposition
    {
        return new Proposition($objectArrayFormat['idProposition'], $objectArrayFormat['idQuestion'], $objectArrayFormat['titreProposition'], $objectArrayFormat['loginAuteur']);
    }

    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'themis."Propositions"';
    }

    /**
     * @inheritDoc
     */
    protected function getPrimaryKey(): string
    {
        return "idProposition";
    }

    /**
     * @inheritDoc
     */
    protected function getColumnNames(): array
    {
        return [
            "idQuestion",
            "titreProposition",
            "loginAuteur",
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getOrderColumn(): string
    {
        return "titreProposition";
    }
}