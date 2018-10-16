<?php
namespace LeoGalleguillos\Vote\Model\Service\ByIp;

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
        int $typeId
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

        if ($rowsAffected == 2) {
            // Decrement downvotes
        }

        $this->connection->commit();
    }
}
