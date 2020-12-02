<?php
namespace MonthlyBasis\Vote\Model\Service\VoteByIp\UpVote;

use MonthlyBasis\Vote\Model\Table as VoteTable;
use Laminas\Db\Adapter\Driver\Pdo\Connection;
use Laminas\Db\Adapter\Exception\InvalidQueryException;

class Remove
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

    public function remove(
        string $ip,
        int $entityTypeId,
        int $typeId
    ): bool {
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

        try {
            $this->votesTable->decrementUpVotes(
                $entityTypeId,
                $typeId
            );
        } catch (InvalidQueryException $invalidQueryException) {
            $this->connection->commit();
            return false;
        }

        $this->connection->commit();
        return true;
    }
}
