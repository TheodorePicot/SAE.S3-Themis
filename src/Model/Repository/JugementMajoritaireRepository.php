<?php

namespace Themis\Model\Repository;

use PDOException;
use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\JugementMajoritaire;
use Themis\Model\DataObject\Vote;

/**
 *
 */
class JugementMajoritaireRepository extends VoteRepository
{

    /**
     * @param array $objectArrayFormat
     * @return JugementMajoritaire
     */
    public function build(array $objectArrayFormat): JugementMajoritaire
    {
        return new JugementMajoritaire($objectArrayFormat["loginVotant"], $objectArrayFormat["idProposition"], $objectArrayFormat["valeur"]);
    }

    /**
     * @param $loginVotant
     * @param $idProposition
     * @return Vote|null
     */
    public function selectVote($loginVotant, $idProposition): ?Vote
    {
        $sqlQuery = 'SELECT * FROM ' . $this->getTableName() . '
                    WHERE "loginVotant" = :loginVotant
                    AND "idProposition" = :idProposition';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'loginVotant' => $loginVotant,
            'idProposition' => $idProposition
        );

        try {
            $pdoStatement->execute($values);
        } catch (PDOException $exception) {
            echo $exception->getCode();
//            return $exception->getCode();
        }

        $dataObject = $pdoStatement->fetch();
        if (!$dataObject) return null;

        return $this->build($dataObject);
    }

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'themis."JugementMajoritaire"';
    }

    /**
     * @return string[]
     */
    protected function getColumnNames(): array
    {
        return [
            "loginVotant",
            "idProposition",
            "valeur"
        ];
    }

    /**
     * @return string
     */
    protected function getOrderColumn(): string
    {
        return "loginVotant";
    }

    /**
     * @return string
     */
    protected function getPrimaryKey(): string
    {
        return 'login, idProposition';
    }

    /**
     * @param AbstractDataObject $dataObject
     * @return void
     */
    public function update(AbstractDataObject $dataObject): void
    {
        $sqlQuery = 'UPDATE "JugementMajoritaire" SET "valeur" =:valeur WHERE "loginVotant" =:loginVotant AND "idProposition" =:idProposition';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = $dataObject->tableFormat();
        $pdoStatement->execute($values);
    }

    /**
     * @param int $idProposition
     * @return int[]
     */
    public function getValeurFrequenceProposition(int $idProposition): array
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE \"idProposition\" =:idProposition";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = ["idProposition" => $idProposition];
        $pdoStatement->execute($values);
        $valeurFrequence = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        foreach ($pdoStatement as $jugementMajoritaire) {
            $object = $this->build($jugementMajoritaire);
            switch ($object->getValeur()) {
                case 0:
                    $valeurFrequence[0]++;
                    break;
                case 1:
                    $valeurFrequence[1]++;
                    break;
                case 2:
                    $valeurFrequence[2]++;
                    break;
                case 3:
                    $valeurFrequence[3]++;
                    break;
                case 4:
                    $valeurFrequence[4]++;
                    break;
                case 5:
                    $valeurFrequence[5]++;
                    break;
            }
        }
        return $valeurFrequence;
    }

    /**
     * @param string $loginVotant
     * @param int $idProposition
     * @return bool
     */
    public function votantHasAlreadyVoted(string $loginVotant, int $idProposition): bool
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} 
                    WHERE \"idProposition\" =:idProposition
                    AND \"loginVotant\" =:loginVotant";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'loginVotant' => $loginVotant,
            'idProposition' => $idProposition
        );

        $pdoStatement->execute($values);

        return $pdoStatement->rowCount() > 0;
    }

    /**
     * @param int $idQuestion
     * @return array
     */
    public function getValeurFrequencePropositionsByQuestion(int $idQuestion): array
    {
        $sqlQuery = "SELECT * FROM \"Propositions\" WHERE \"idQuestion\" =:idQuestion ORDER BY \"idProposition\"";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = ["idQuestion" => $idQuestion];
        $pdoStatement->execute($values);
        $frequenceForEachProposition = array();
        foreach ($pdoStatement as $jugementMajoritaire) {
            $object = (new PropositionRepository())->build($jugementMajoritaire);
            $frequenceForEachProposition[$object->getIdProposition()] = $this->getValeurFrequenceProposition($object->getIdProposition());
        }
        return $frequenceForEachProposition;
    }

    /**
     * @param int $idProposition
     * @return int
     */
    public function getNbVote(int $idProposition): int
    {
        $sqlQuery = "SELECT COUNT(*) FROM {$this->getTableName()} WHERE \"idProposition\" =:idProposition";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = ["idProposition" => $idProposition];
        $pdoStatement->execute($values);
        return (int)$pdoStatement->fetch()[0];
    }

    /**
     * @param array $values
     * @param int $idQuestion
     * @return array
     */
    public function selectPropositionForVoteResult(array $values, int $idQuestion): array
    {
        $propositionTemp = (new PropositionRepository())->selectByQuestion($idQuestion);
        $propositionOrdered = array();
        foreach ($propositionTemp as $proposition) {
            $proposition->setValeurResultat($values[$proposition->getIdProposition()]);
            $proposition->setListeValeur($this->getValeurFrequenceProposition($proposition->getIdProposition()));
            $propositionOrdered[] = $proposition;
        }
        usort($propositionOrdered, fn($a, $b) => -1 * strcmp($a->getValeurResultat(), $b->getValeurResultat()));
        return $propositionOrdered;
    }

}