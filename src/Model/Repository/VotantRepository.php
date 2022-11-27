<?php

namespace Themis\Model\Repository;

class VotantRepository extends AbstractParticipantRepository
{
    protected function getTableName(): string
    {
        return 'themis."estVotant"';
    }

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

    public function isParticpantInQuestionV2(string $login, int $idQuestion): bool //TODO FIX THIS BOI
    {
        $votantsInQuestion = $this->selectAllByQuestion($idQuestion);
        var_dump($votantsInQuestion);
        $votant1 = $this->select($login);

        foreach ($votantsInQuestion as $votant) {
            if ($votant1 == $votant) return true;
        }
        return false;
//        return in_array($votant, $votantsInQuestion);
    }
}