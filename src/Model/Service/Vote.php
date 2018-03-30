<?php
namespace LeoGalleguillos\Vote\Model\Service;

use LeoGalleguillos\Entity\Model\Entity as EntityEntity;
use LeoGalleguillos\User\Model\Entity as UserEntity;
use LeoGalleguillos\Vote\Model\Table as VoteTable;

class Vote
{
    public function __construct(
        VoteTable\Vote $voteTable
    ) {
        $this->voteTable = $voteTable;
    }

    public function vote(
        UserEntity\User $userEntity,
        EntityEntity\Entity $entityEntity = null,
        EntityEntity\EntityType $entityTypeEntity,
        int $typeId,
        int $value
    ) {
        return $this->voteTable->insertOnDuplicateKeyUpdate(
            $userEntity->getUserId(),
            null,
            $entityTypeEntity->getEntityTypeId(),
            $typeId,
            $value
        );
    }
}
