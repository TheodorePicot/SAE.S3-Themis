<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\Question;

class QuestionRepository extends AbstractRepository
{
    /**
     * Permet d'obtenir une liste de toute les questions possédant le string pplacé en paramètre dans le titre de la
     * question et/ou dans sa description
     *
     * @param string $element
     * @return array
     */
    public function selectAllBySearchValue(string $element): array
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE LOWER(\"titreQuestion\") LIKE ? OR LOWER(\"descriptionQuestion\") LIKE ?";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array("%" . strtolower($element) . "%", "%" . strtolower($element) . "%"));

        $questions = array();
        foreach ($pdoStatement as $question) {
            $questions[] = $this->build($question);
        }
        return $questions;
    }

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'themis."Questions"';
    }

    /**
     * @inheritDoc
     */
    public function build(array $objectArrayFormat): Question
    {
        return new Question($objectArrayFormat["idQuestion"],
            $objectArrayFormat["titreQuestion"],
            $objectArrayFormat["descriptionQuestion"],
            $objectArrayFormat["dateDebutProposition"],
            $objectArrayFormat["dateFinProposition"],
            $objectArrayFormat["dateDebutVote"],
            $objectArrayFormat["dateFinVote"],
            $objectArrayFormat["loginOrganisateur"],
            $objectArrayFormat["systemeVote"]);
    }

    /**
     * Permet d'obtenir une liste de toute les questions qui sont en cour d'écriture
     *
     * C'est-à-dire que la date courante est entre la date de début de d'écriture de proposition et la date de
     * fin d'écriture de proposition
     *
     * @param string $element
     * @return array
     */
    public function selectAllCurrentlyInWriting(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()} WHERE CURRENT_TIMESTAMP + interval '1 hour' >= " . '"dateDebutProposition" AND CURRENT_TIMESTAMP + interval ' . "'1 hour'" . '<= "dateFinProposition"');

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    /**
     * Permet d'obtenir une liste de toute les questions qui sont en cour de vote
     *
     * C'est-à-dire que la date courante est entre la date de début de la période de vote  et la date de
     * fin de la période de vote
     *
     * @param string $element
     * @return array
     */
    public function selectAllCurrentlyInVoting(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()} WHERE CURRENT_TIMESTAMP + interval '1 hour' >= " . '"dateDebutVote" AND CURRENT_TIMESTAMP + interval ' . "'1 hour'" . '<= "dateFinVote"');

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    /**
     * Permet d'obtenir une liste de toute les questions qui ont sont terminés
     *
     * C'est-à-dire que la date courante a dépassé la date de fin de la période de vote
     * Par conséquent ont peut connaitre la proposition gagnante
     *
     * @param string $element
     * @return array
     */
    public function selectAllFinished(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()} WHERE CURRENT_TIMESTAMP + interval '1 hour' > " . '"dateFinVote"');

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    /**
     * Permet d'obtenir une liste de toute les questions écrite par l'utilisateur qui possède le $login en paramètre
     *
     * @param string $login
     * @return array
     */
    public function selectAllByUser(string $login): array
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE " . '"loginOrganisateur" = ?';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array($login));

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    /**
     * Permet d'obtenir une liste de toute les questions de la BD rangé par l'ordre décroissant par rapport à l'idée
     *
     * @param string $login
     * @return array
     */
    public function selectAllByIdQuestion(): array
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} ORDER BY \"idQuestion\" DESC";
        $pdoStatement = DatabaseConnection::getPdo()->query($sqlQuery);

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    /**
     * @inheritDoc
     */
    protected function getPrimaryKey(): string
    {
        return "idQuestion";
    }

    /**
     * @inheritDoc
     */
    protected function getColumnNames(): array
    {
        return [
            "titreQuestion",
            "descriptionQuestion",
            "dateDebutProposition",
            "dateFinProposition",
            "dateDebutVote",
            "dateFinVote",
            "loginOrganisateur",
            "systemeVote"
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getColumnTitle(): string
    {
        return "titreQuestion";
    }

    /**
     * @inheritDoc
     */
    protected function getOrderColumn(): string
    {
        return '"Questions"."titreQuestion"';
    }
}