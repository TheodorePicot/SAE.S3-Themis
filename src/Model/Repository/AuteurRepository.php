<?php

namespace Themis\Model\Repository;

class AuteurRepository extends AbstractParticipantRepository
{
    protected function getTableName(): string
    {
        return 'themis."estAuteur"';
    }

    public function isParticpantInQuestion(string $login, int $idQuestion): bool
    {
        $sqlQuery = "SELECT isAuteurInQuestion(:login, :idQuestion)";

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'login' => $login,
            'idQuestion' => $idQuestion
        );

        $pdoStatement->execute($values);

        $dataObject = $pdoStatement->fetch();

        if ($dataObject['isauteurinquestion'] == "true") return true;
        else return false;
    }
}