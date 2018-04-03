<?php
namespace LeoGalleguillos\VoteTest\Model\Table;

use ArrayObject;
use Exception;
use Generator;
use LeoGalleguillos\Vote\Model\Table as VoteTable;
use LeoGalleguillos\VoteTest\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class VoteTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath = __DIR__ . '/../../..' . '/sql/leogalle_test/vote/';

    protected function setUp()
    {
        $configArray     = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray     = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter   = new Adapter($configArray);

        $this->voteTable      = new VoteTable\Vote($this->adapter);

        $this->setForeignKeyChecks0();
        $this->dropTable();
        $this->createTable();
        $this->setForeignKeyChecks1();
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
            VoteTable\Vote::class,
            $this->voteTable
        );
    }

    public function testInsertOnDuplicateKeyUpdate()
    {
        $voteId = $this->voteTable->insertOnDuplicateKeyUpdate(
            1,
            2,
            3,
            4,
            5
        );
        $this->assertSame($voteId, 1);

        $voteId = $this->voteTable->insertOnDuplicateKeyUpdate(
            1,
            2,
            3,
            4,
            5
        );
        $this->assertSame($voteId, 1);

        $this->assertSame(
            $this->voteTable->selectCount(),
            1
        );
    }

    public function testSelectWhereUserIdEntityTypeIdTypeId()
    {
        try {
            $this->voteTable->selectWhereUserIdEntityTypeIdTypeId(1, 2, 3);
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Matching row could not be found.',
                $exception->getMessage()
            );
        }
    }
}
