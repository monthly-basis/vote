<?php
namespace LeoGalleguillos\Vote\Model\Service\VoteByIp;

use LeoGalleguillos\Vote\Model\Table as VoteTable;
use Zend\Db\Adapter\Driver\Pdo\Connection;

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
    ) {
        $this->connection->beginTransaction();

        $rowsAffected = $this->voteByIpTable->insertOnDuplicateKeyUpdate(
            $ip,
            $entityTypeId,
            $typeId,
            1
        );

        if (empty($rowsAffected)) {
            $this->connection->commit();
            return;
        }

        $this->votesTable->insertIgnore(
            $entityTypeId,
            $typeId
        );
        $this->votesTable->incrementUpVotes(
            $entityTypeId,
            $typeId
        );

        // This logic won't ever be called yet.
        if ($currentValue == -1) {
            $this->votesTable->decrementDownVotes(
                $entityTypeId,
                $typeId
            );
        }

        $this->connection->commit();
    }
}
