<?php
namespace LeoGalleguillos\Vote\Model\Service\Votes;

use LeoGalleguillos\Vote\Model\Factory as VoteFactory;
use LeoGalleguillos\Vote\Model\Table as VoteTable;

class Multiple
{
    public function __construct(
        VoteFactory\Votes $votesFactory,
        VoteTable\Votes $votesTable
    ) {
        $this->votesFactory = $votesFactory;
        $this->votesTable   = $votesTable;
    }

    /**
     * Get multiple votes entities.
     */
    public function getMultiple(
        int $entityTypeId,
        array $typeIds
    ): array {
        $votesEntities = [];

        $generator = $this->votesTable->selectWhereEntityTypeIdAndTypeIdIn(
            $entityTypeId,
            $typeIds
        );
        foreach ($generator as $array) {
            $votesEntity = $this->votesFactory->buildFromArray($array);
            $votesEntities[$array['type_id']] = $votesEntity;
        }

        return $votesEntities;
    }
}
