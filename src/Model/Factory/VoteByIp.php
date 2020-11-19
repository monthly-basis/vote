<?php
namespace LeoGalleguillos\Vote\Model\Factory;

use LeoGalleguillos\Vote\Model\Entity as VoteEntity;
use LeoGalleguillos\Vote\Model\Table as VoteTable;
use TypeError;

class VoteByIp
{
    public function __construct(
        VoteTable\VoteByIp $voteByIpTable
    ) {
        $this->voteByIpTable = $voteByIpTable;
    }

    public function buildFromIpEntityTypeIdTypeId(
        string $ip,
        int $entityTypeId,
        int $typeId
    ): VoteEntity\VoteByIp {
        try {
            $array = $this->voteByIpTable->selectWhereIpEntityTypeIdTypeId(
                $ip,
                $entityTypeId,
                $typeId
            );
        } catch (TypeError $typeError) {
            return $this->buildDefault();
        }

        return $this->buildFromArray($array);
    }

    public function buildFromArray(array $array): VoteEntity\VoteByIp
    {
        $voteByIpEntity = new VoteEntity\VoteByIp();
        $voteByIpEntity->setValue($array['value']);
        return $voteByIpEntity;
    }

    public function buildDefault(): VoteEntity\VoteByIp
    {
        $voteByIpEntity = new VoteEntity\VoteByIp();
        $voteByIpEntity->setValue(0);
        return $voteByIpEntity;
    }
}
