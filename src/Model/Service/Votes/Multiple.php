<?php
namespace MonthlyBasis\Vote\Model\Service\Votes;

use MonthlyBasis\Vote\Model\Factory as VoteFactory;
use MonthlyBasis\Vote\Model\Table as VoteTable;

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
        if (empty($typeIds)) {
            return [];
        }

        $votesEntities = [];

        $generator = $this->votesTable->selectWhereEntityTypeIdAndTypeIdIn(
            $entityTypeId,
            $typeIds
        );
        foreach ($generator as $array) {
            $votesEntity = $this->votesFactory->buildFromArray($array);
            $votesEntities[$array['type_id']] = $votesEntity;
        }

        foreach ($typeIds as $typeId) {
            if (empty($votesEntities[$typeId])) {
                $votesEntities[$typeId] = $this->votesFactory->buildDefault();
            }
        }

        return $votesEntities;
    }
}
