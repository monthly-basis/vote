<?php
namespace LeoGalleguillos\VoteTest\Model\Service;

use Exception;
use LeoGalleguillos\Entity\Model\Entity as EntityEntity;
use LeoGalleguillos\User\Model\Entity as UserEntity;
use LeoGalleguillos\Vote\Model\Entity as VoteEntity;
use LeoGalleguillos\Vote\Model\Factory as VoteFactory;
use LeoGalleguillos\Vote\Model\Service as VoteService;
use LeoGalleguillos\Vote\Model\Table as VoteTable;
use PHPUnit\Framework\TestCase;

class VoteTest extends TestCase
{
    protected function setUp()
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
