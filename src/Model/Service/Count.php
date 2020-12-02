<?php
namespace LeoGalleguillos\Vote\Model\Service;

use LeoGalleguillos\Entity\Model\Entity as EntityEntity;
use MonthlyBasis\User\Model\Entity as UserEntity;
use LeoGalleguillos\Vote\Model\Table as VoteTable;

class Count
{
    public function __construct(
        VoteTable\Vote $voteTable
    ) {
        $this->voteTable = $voteTable;
    }

    public function getCount(
        EntityEntity\EntityType $entityTypeEntity,
        int $typeId,
        int $value
    ) : int {
        return $this->voteTable->selectWhereEntityTypeIdTypeIdValue(
            $entityTypeEntity->getEntityTypeId(),
            $typeId,
            $value
        );
    }
}
