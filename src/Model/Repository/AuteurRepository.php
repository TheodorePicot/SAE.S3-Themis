<?php

namespace Themis\Model\Repository;

class AuteurRepository extends AbstractParticipantRepository
{
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

        return $dataObject['isauteurinquestion'] == "true";
    }

    protected function getTableName(): string
    {
        return 'themis."estAuteur"';
    }




}