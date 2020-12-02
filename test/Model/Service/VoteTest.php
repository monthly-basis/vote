<?php
namespace MonthlyBasis\VoteTest\Model\Service;

use Exception;
use MonthlyBasis\Entity\Model\Entity as EntityEntity;
use MonthlyBasis\User\Model\Entity as UserEntity;
use MonthlyBasis\Vote\Model\Entity as VoteEntity;
use MonthlyBasis\Vote\Model\Factory as VoteFactory;
use MonthlyBasis\Vote\Model\Service as VoteService;
use MonthlyBasis\Vote\Model\Table as VoteTable;
use PHPUnit\Framework\TestCase;

class VoteTest extends TestCase
{
    protected function setUp(): void
    {
        $this->voteTableMock = $this->createMock(
            VoteTable\Vote::class
        );
        $this->voteService = new VoteService\Vote(
            $this->voteTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            VoteService\Vote::class,
            $this->voteService
        );
    }

    public function testVote()
    {
        $userEntity = new UserEntity\User();
        $userEntity->setUserId(1);
        $entityTypeEntity = new EntityEntity\EntityType();
        $entityTypeEntity->setEntityTypeId(1);

        $this->voteTableMock->method('insertOnDuplicateKeyUpdate')->willReturn(
            1
        );

        $voteId = $this->voteService->vote(
            $userEntity,
            null,
            $entityTypeEntity,
            1,
            -1
        );
        $this->assertSame($voteId, 1);
    }
}
