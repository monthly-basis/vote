<?php
namespace LeoGalleguillos\Vote\Model\Service\VoteByIp;

use LeoGalleguillos\Vote\Model\Table as VoteTable;
use Zend\Db\Adapter\Driver\Pdo\Connection;

class DownVote
{
    public function __construct(
        Connection $connection,
        VoteTable\VoteByIp $voteByIpTable,
        VoteTable\Votes $votesTable
    ) {
        $this->connection    = $connection;
        $this->voteByIpTable = $voteByIpTable;
        $this->votesTable    = $votesTable;
    }

    public function downVote(
        string $ip,
        int $entityTypeId,
        int $typeId,
        int $currentValue
    ): bool {
        $this->connection->beginTransaction();

        $affectedRows = $this->voteByIpTable->insertOnDuplicateKeyUpdate(
            $ip,
            $entityTypeId,
            $typeId,
            -1
        );

        if ($affectedRows == 0) {
            $this->connection->rollback();
            return false;
        }

        $this->votesTable->insertIgnore(
            $entityTypeId,
            $typeId
        );
        $this->votesTable->incrementDownVotes(
            $entityTypeId,
            $typeId
        );

        if ($currentValue == 1) {
            $this->votesTable->decrementUpVotes(
                $entityTypeId,
                $typeId
            );
        }

        $this->connection->commit();

        return true;
    }
}
