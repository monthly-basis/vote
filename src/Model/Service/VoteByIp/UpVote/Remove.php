<?php
namespace LeoGalleguillos\Vote\Model\Service\VoteByIp\UpVote;

use LeoGalleguillos\Vote\Model\Table as VoteTable;
use Zend\Db\Adapter\Driver\Pdo\Connection;

class Remove
{
    public function __construct(
        Connection $connection,
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
        $this->connection->beginTransaction();

        $rowsAffected = $this->voteByIpTable->update(
            0,
            $ip,
            $entityTypeId,
            $typeId
        );

        if (empty($rowsAffected)) {
            $this->connection->rollback();
            return false;
        }

        if ($rowsAffected == 1) {
            $this->votesTable->decrementUpVotes(
                $entityTypeId,
                $typeId
            );
        }

        $this->connection->commit();

        return true;
    }
}
