<?php
namespace MonthlyBasis\Vote\Model\Factory;

use MonthlyBasis\Vote\Model\Entity as VoteEntity;
use MonthlyBasis\Vote\Model\Table as VoteTable;
use TypeError;

class Votes
{
    public function __construct(
        VoteTable\Votes $votesTable
    ) {
        $this->votesTable = $votesTable;
    }

    public function buildFromEntityTypeIdTypeId(
        int $entityTypeId,
        int $typeId
    ): VoteEntity\Votes {
        try {
            $array = $this->votesTable->select(
                $entityTypeId,
                $typeId
            );
        } catch (TypeError $typeError) {
            return $this->buildDefault();
        }

        return $this->buildFromArray($array);
    }

    public function buildFromArray(array $array): VoteEntity\Votes
    {
        $votesEntity = new VoteEntity\Votes();
        $votesEntity->setDownVotes($array['down_votes'])
                    ->setUpVotes($array['up_votes']);
        return $votesEntity;
    }

    public function buildDefault(): VoteEntity\Votes
    {
        $votesEntity = new VoteEntity\Votes();
        $votesEntity->setDownVotes(0)
                    ->setUpVotes(0);
        return $votesEntity;
    }
}
