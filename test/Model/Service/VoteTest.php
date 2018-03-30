<?php
namespace LeoGalleguillos\VoteTest\Model\Service;

use Exception;
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
}
