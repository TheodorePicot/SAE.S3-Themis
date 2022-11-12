<?php

namespace Themis\Model\Repository;

class AuteurRepository extends AbstractParticipantRepository
{
    protected function getTableName(): string
    {
        return 'themis."estAuteur"';
    }
}