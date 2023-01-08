<?php

namespace Themis\Model\Repository;

use PDOException;

class VotantRepository extends AbstractParticipantRepository
{
    public function isParticpantInQuestion(string $login, int $idQuestion): bool
    {
        $sqlQuery = "SELECT isVotantInQuestion(:login, :idQuestion)";

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'login' => $login,
            'idQuestion' => $idQuestion
        );

        $pdoStatement->execute($values);

        $dataObject = $pdoStatement->fetch();

        if ($dataObject['isvotantinquestion'] == "true") return true;
        else return false;
    }

    protected function getTableName(): string
    {
        return 'themis."estVotant"';
    }
}