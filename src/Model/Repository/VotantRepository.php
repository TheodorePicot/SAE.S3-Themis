<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Participant;

class VotantRepository extends AbstractParticipantRepository
{
    protected function getTableName(): string
    {
        return 'themis."estVotant"';
    }
}