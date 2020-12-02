<?php
namespace MonthlyBasis\Vote\Model\Service\VoteByIp;

use MonthlyBasis\Vote\Model\Table as VoteTable;
use Laminas\Db\Adapter\Driver\Pdo\Connection;

class UpVote
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

    public function upVote(
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
            1
        );

        if ($affectedRows == 0) {
            $this->connection->rollback();
            return false;
        }

        $this->votesTable->insertIgnore(
            $entityTypeId,
            $typeId
        );
        $this->votesTable->incrementUpVotes(
            $entityTypeId,
            $typeId
        );

        if ($currentValue == -1) {
            $this->votesTable->decrementDownVotes(
                $entityTypeId,
                $typeId
            );
        }

        $this->connection->commit();

        return true;
    }
}
