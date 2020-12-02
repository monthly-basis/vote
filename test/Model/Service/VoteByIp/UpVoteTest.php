<?php
namespace LeoGalleguillos\VoteTest\Model\Service\VoteByIp;

use Exception;
use MonthlyBasis\Entity\Model\Entity as EntityEntity;
use MonthlyBasis\User\Model\Entity as UserEntity;
use LeoGalleguillos\Vote\Model\Entity as VoteEntity;
use LeoGalleguillos\Vote\Model\Factory as VoteFactory;
use LeoGalleguillos\Vote\Model\Service as VoteService;
use LeoGalleguillos\Vote\Model\Table as VoteTable;
use PHPUnit\Framework\TestCase;
use Zend\Db\Adapter\Driver\Pdo\Connection;

class UpVoteTest extends TestCase
{
    protected function setUp(): void
    {
        $this->connectionMock = $this->createMock(
            Connection::class
        );
        $this->voteByIpTableMock = $this->createMock(
            VoteTable\VoteByIp::class
        );
        $this->votesTableMock = $this->createMock(
            VoteTable\Votes::class
        );
        $this->upVoteService = new VoteService\VoteByIp\UpVote(
            $this->connectionMock,
            $this->voteByIpTableMock,
            $this->votesTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            VoteService\VoteByIp\UpVote::class,
            $this->upVoteService
        );
    }
}
