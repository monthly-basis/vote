<?php
namespace MonthlyBasis\Vote\Model\Factory;

use Exception;
use MonthlyBasis\Entity\Model\Entity as EntityEntity;
use MonthlyBasis\User\Model\Entity as UserEntity;
use MonthlyBasis\Vote\Model\Entity as VoteEntity;
use MonthlyBasis\Vote\Model\Table as VoteTable;

class Vote
{
    public function __construct(
        VoteTable\Vote $voteTable
    ) {
        $this->voteTable = $voteTable;
    }

    public function buildFromUserEntityEntityTypeEntityTypeId(
        UserEntity\User $userEntity,
        EntityEntity\EntityType $entityTypeEntity,
        int $typeId
    ) : VoteEntity\Vote {
        try {
            $array = $this->voteTable->selectWhereUserIdEntityTypeIdTypeId(
                $userEntity->getUserId(),
                $entityTypeEntity->getEntityTypeId(),
                $typeId
            );
        } catch (Exception $exception) {
            throw new Exception('Vote could not be build, no matching row found.');
        }

        return $this->buildFromArray($array);
    }

    public function buildFromArray(array $array) : VoteEntity\Vote
    {
        $voteEntity = new VoteEntity\Vote();

        $voteEntity->setValue($array['value']);

        return $voteEntity;
    }
}
