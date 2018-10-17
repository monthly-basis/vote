<?php
namespace LeoGalleguillos\Vote\Model\Factory\Vote;

use LeoGalleguillos\Entity\Model\Entity as EntityEntity;
use LeoGalleguillos\User\Model\Entity as UserEntity;
use LeoGalleguillos\Vote\Model\Entity as VoteEntity;
use LeoGalleguillos\Vote\Model\Table as VoteTable;
use TypeError;

class ByIp
{
    public function __construct(
        VoteTable\VoteByIp $voteByIpTable
    ) {
        $this->voteByIpTable = $voteByIpTable;
    }

    public function buildFromIpEntityTypeIdAndTypeId(
        string $ip,
        int $entityTypeId,
        int $typeId
    ): VoteEntity\Vote\VoteByIp {
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

    public function buildFromArray(array $array): VoteEntity\Vote\VoteByIp
    {
        $voteByIpEntity = new VoteEntity\Vote\ByIp();
        $voteByIpEntity->setValue($array['value']);
        return $voteByIpEntity;
    }

    public function buildDefault()
    {
        $voteByIpEntity = new VoteEntity\Vote\ByIp();
        $voteByIpEntity->setValue(0);
        return $voteByIpEntity;
    }
}
