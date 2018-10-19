<?php
namespace LeoGalleguillos\VoteTest\Model\Table;

use LeoGalleguillos\Vote\Model\Table as VoteTable;
use LeoGalleguillos\VoteTest\TableTestCase;
use TypeError;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Exception\InvalidQueryException;

class VotesTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath = __DIR__ . '/../../..' . '/sql/leogalle_test/votes/';

    protected function setUp()
    {
        $configArray     = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray     = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter   = new Adapter($configArray);

        $this->votesTable      = new VoteTable\Votes($this->adapter);

        $this->dropTable();
        $this->createTable();
    }

    protected function dropTable()
    {
        $sql = file_get_contents($this->sqlPath . 'drop.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    protected function createTable()
    {
        $sql = file_get_contents($this->sqlPath . 'create.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            VoteTable\Votes::class,
            $this->votesTable
        );
    }

    public function testDecrementUpVotes()
    {
        $affectedRows = $this->votesTable->decrementUpVotes(
            1,
            12345
        );
        $this->assertSame(
            0,
            $affectedRows
        );

        $this->votesTable->insertIgnore(
            1,
            12345
        );
        try {
            $affectedRows = $this->votesTable->decrementUpVotes(
                1,
                12345
            );
            $this->fail();
        } catch (InvalidQueryException $invalidQueryException) {
            $this->assertSame(
                'Statement could not be executed',
                substr($invalidQueryException->getMessage(), 0, 31)
            );
        }

        $this->votesTable->incrementUpVotes(
            1,
            12345
        );
        $this->assertSame(
            '1',
            $this->votesTable->select(1, 12345)['up_votes']
        );

        $affectedRows = $this->votesTable->decrementUpVotes(
            1,
            12345
        );
        $this->assertSame(
            1,
            $affectedRows
        );
        $this->assertSame(
            '0',
            $this->votesTable->select(1, 12345)['up_votes']
        );
    }

    public function testIncrementUpVotes()
    {
        $affectedRows = $this->votesTable->incrementUpVotes(
            1,
            12345
        );
        $this->assertSame(
            0,
            $affectedRows
        );

        $this->votesTable->insertIgnore(
            1,
            12345
        );
        $this->assertSame(
            '0',
            $this->votesTable->select(1, 12345)['up_votes']
        );

        $affectedRows = $this->votesTable->incrementUpVotes(
            1,
            12345
        );
        $this->assertSame(
            1,
            $affectedRows
        );
        $this->assertSame(
            '1',
            $this->votesTable->select(1, 12345)['up_votes']
        );
    }

    public function testInsertIgnore()
    {
        $affectedRows = $this->votesTable->insertIgnore(
            12345,
            67890
        );
        $this->assertSame(
            1,
            $affectedRows
        );

        $affectedRows = $this->votesTable->insertIgnore(
            12345,
            67890
        );
        $this->assertSame(
            0,
            $affectedRows
        );
    }

    public function testSelect()
    {
        try {
            $array = $this->votesTable->select(
                11111,
                22222
            );
            $this->fail();
        } catch (TypeError $typeError) {
            $this->assertSame(
                'Return value',
                substr($typeError->getMessage(), 0, 12)
            );
        }

        $this->votesTable->insertIgnore(
            11111,
            22222
        );
        $array = $this->votesTable->select(
            11111,
            22222
        );
        $this->assertSame(
            '0',
            $array['up_votes']
        );
        $this->assertSame(
            '0',
            $array['down_votes']
        );
    }

    public function testSelectWhereEntityTypeIdAndTypeIdIn()
    {
        $generator = $this->votesTable->selectWhereEntityTypeIdAndTypeIdIn(
            11111,
            [1, 2, 3, 4, 5]
        );
        $array = iterator_to_array($generator);
        $this->assertEmpty($array);

        $this->votesTable->insertIgnore(
            11111,
            2
        );
        $this->votesTable->insertIgnore(
            11111,
            5
        );
        $generator = $this->votesTable->selectWhereEntityTypeIdAndTypeIdIn(
            11111,
            [1, 2, 3, 4, 5]
        );
        $array = iterator_to_array($generator);
        $this->assertSame(
            '2',
            $array[0]['type_id']
        );
        $this->assertSame(
            '5',
            $array[1]['type_id']
        );
    }
}
