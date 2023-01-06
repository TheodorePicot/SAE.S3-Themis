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

    public function votantHasAlreadyVoted(string $loginVotant, int $idProposition): bool
    {
        $sqlQuery = 'SELECT * FROM themis."Votes" 
                    WHERE "loginVotant" = :loginVotant
                    AND "idProposition" = :idProposition';
//        echo $sqlQuery;
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'loginVotant' => $loginVotant,
            'idProposition' => $idProposition
        );

        try {
            $pdoStatement->execute($values);
        } catch (PDOException $exception) {
            echo $exception->getCode();
            return $exception->getCode();
        }
        $dataObject = $pdoStatement->fetch();
//        echo $dataObject[0];
        if ($dataObject != false) {
            return $dataObject[0] == $loginVotant;
        }
        return false;
    }

    public function selectAllVotantsBySearchValue(string $element, int $idQuestion)
    {

        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE " . '"idQuestion"=?' . ' AND LOWER("login") LIKE ? ';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array($idQuestion ,"%" . strtolower($element) . "%"));

        $users = array();
        foreach ($pdoStatement as $user) {
            $users[] = $this->build($user);
        }
        return $users;
    }

}