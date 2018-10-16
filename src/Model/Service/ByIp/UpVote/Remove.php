<?php
namespace LeoGalleguillos\Vote\Model\Service\ByIp\Upvote;

use LeoGalleguillos\Vote\Model\Table as VoteTable;

class Remove
{
    public function __construct(
        VoteTable\VoteByIp $voteByIpTable,
        VoteTable\Votes $votesTable
    ) {
        $this->voteByIpTable = $voteByIpTable;
        $this->votesTable    = $votesTable;
    }

    public function remove(
        string $ip,
        int $entityTypeId,
        int $typeId
    ) {
        $rowsAffected = $this->voteByIpTable->update(
            0,
            $ip,
            $entityTypeId,
            $typeId
        );

        if (empty($rowsAffected)) {
            return;
        }

        if ($rowsAffected == 1) {
            $this->votesTable->decrementUpVotes(
                $entityTypeId,
                $typeId
            );
        }
    }
}
