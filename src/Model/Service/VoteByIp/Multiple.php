<?php
namespace MonthlyBasis\Vote\Model\Service\VoteByIp;

use MonthlyBasis\Vote\Model\Factory as VoteFactory;
use MonthlyBasis\Vote\Model\Table as VoteTable;

class Multiple
{
    public function __construct(
        VoteFactory\VoteByIp $voteByIpFactory,
        VoteTable\VoteByIp $voteByIpTable
    ) {
        $this->voteByIpFactory = $voteByIpFactory;
        $this->voteByIpTable   = $voteByIpTable;
    }

    /**
     * Get multiple vote by ip entities.
     */
    public function getMultiple(
        string $ip,
        int $entityTypeId,
        array $typeIds
    ): array {
        if (empty($typeIds)) {
            return [];
        }

        $voteByIpEntities = [];

        $generator = $this->voteByIpTable->selectWhereIpAndEntityTypeIdAndTypeIdIn(
            $ip,
            $entityTypeId,
            $typeIds
        );
        foreach ($generator as $array) {
            $voteByIpEntity = $this->voteByIpFactory->buildFromArray($array);
            $voteByIpEntities[$array['type_id']] = $voteByIpEntity;
        }

        foreach ($typeIds as $typeId) {
            if (empty($voteByIpEntities[$typeId])) {
                $voteByIpEntities[$typeId] = $this->voteByIpFactory->buildDefault();
            }
        }

        return $voteByIpEntities;
    }
}
