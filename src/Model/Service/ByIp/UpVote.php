<?php
namespace LeoGalleguillos\Vote\Model\Service\ByIp;

use LeoGalleguillos\Vote\Model\Table as VoteTable;

class UpVote
{
    public function __construct(
        VoteTable\VoteByIp $voteByIpTable,
        VoteTable\Votes $votesTable
    ) {
        $this->voteByIpTable = $voteByIpTable;
        $this->votesTable    = $votesTable;
    }

    public function upVote(
        string $ip,
        int $entityTypeId,
        int $typeId
    ) {
        $rowsAffected = $this->voteByIpTable->insertOnDuplicateKeyUpdate(
            $ip,
            $entityTypeId,
            $typeId,
            1
        );

        if (empty($rowsAffected)) {
            return;
        }

        $this->votesTable->insertIgnore(
            $entityTypeId,
            $typeId
        );

        if ($rowsAffected == 1) {
            $this->votesTable->incrementUpVotes(
                $entityTypeId,
                $typeId
            );
        }
    }
}
