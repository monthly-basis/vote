<?php
namespace LeoGalleguillos\Vote\Model\Service;

use LeoGalleguillos\Vote\Model\Table as VoteTable;

class VoteByIp
{
    public function __construct(
        VoteTable\VoteByIp $voteByIpTable,
        VoteTable\Votes $votesTable
    ) {
        $this->voteByIpTable = $voteByIpTable;
        $this->votesTable    = $votesTable;
    }

    public function voteByIp(
        string $ip,
        int $entityTypeId,
        int $typeId,
        int $value
    ) {
        $rowsAffected = $this->voteByIpTable->insertOnDuplicateKeyUpdate(
            $ip,
            $entityTypeId,
            $typeId,
            $value
        );

        if (empty($rowsAffected)) {
            return;
        }

        if ($rowsAffected == 1) {
            // increment appropriate vote
        } elseif ($rowsAffected == 2) {
            // undo previous vote
            // increment appropriate vote
        }
    }
}
