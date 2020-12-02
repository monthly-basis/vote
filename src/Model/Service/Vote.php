<?php
namespace MonthlyBasis\Vote\Model\Service;

use MonthlyBasis\Entity\Model\Entity as EntityEntity;
use MonthlyBasis\User\Model\Entity as UserEntity;
use MonthlyBasis\Vote\Model\Table as VoteTable;

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
