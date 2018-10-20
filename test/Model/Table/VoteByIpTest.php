<?php
namespace LeoGalleguillos\VoteTest\Model\Table;

use LeoGalleguillos\Vote\Model\Table as VoteTable;
use LeoGalleguillos\VoteTest\TableTestCase;
use TypeError;
use Zend\Db\Adapter\Adapter;

class VoteByIpTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath = __DIR__ . '/../../..' . '/sql/leogalle_test/vote_by_ip/';

    protected function setUp()
    {
        $configArray     = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray     = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter   = new Adapter($configArray);

        $this->voteByIpTable      = new VoteTable\VoteByIp($this->adapter);

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
            VoteTable\VoteByIp::class,
            $this->voteByIpTable
        );
    }

    public function testInsertOnDuplicateKeyUpdate()
    {
        $affectedRows = $this->voteByIpTable->insertOnDuplicateKeyUpdate(
            '1.2.3.4',
            1,
            2,
            -1
        );
        $this->assertSame(
            1,
            $affectedRows
        );

        $affectedRows = $this->voteByIpTable->insertOnDuplicateKeyUpdate(
            '1.2.3.4',
            1,
            2,
            -1
        );
        $this->assertSame(
            0,
            $affectedRows
        );

        $affectedRows = $this->voteByIpTable->insertOnDuplicateKeyUpdate(
            '1.2.3.4',
            1,
            2,
            1
        );
        $this->assertSame(
            2,
            $affectedRows
        );
    }

    public function testSelectWhereIpEntityTypeIdTypeId()
    {
        $this->voteByIpTable->insertOnDuplicateKeyUpdate(
            '1.2.3.4',
            123,
            456,
            -1
        );

        try {
            $array = $this->voteByIpTable->selectWhereIpEntityTypeIdTypeId(
                '1.2.3.4',
                1,
                2
            );
            $this->fail();
        } catch (TypeError $typeError) {
            $this->assertSame(
                'Return value',
                substr($typeError->getMessage(), 0, 12)
            );
        }

        $array = $this->voteByIpTable->selectWhereIpEntityTypeIdTypeId(
            '1.2.3.4',
            123,
            456
        );
        $this->assertSame(
            '-1',
            $array['value']
        );
    }

    public function testSelectWhereIpAndEntityTypeIdAndTypeIdIn()
    {
        $generator = $this->voteByIpTable->selectWhereIpAndEntityTypeIdAndTypeIdIn(
            '1.2.3.4',
            11111,
            [1, 2, 3, 4, 5]
        );
        $array = iterator_to_array($generator);
        $this->assertEmpty($array);

        $this->voteByIpTable->insertOnDuplicateKeyUpdate(
            '1.2.3.4',
            11111,
            2,
            1
        );
        $this->voteByIpTable->insertOnDuplicateKeyUpdate(
            '5.6.7.8',
            11111,
            3,
            1
        );
        $this->voteByIpTable->insertOnDuplicateKeyUpdate(
            '1.2.3.4',
            11111,
            5,
            -1
        );
        $generator = $this->voteByIpTable->selectWhereIpAndEntityTypeIdAndTypeIdIn(
            '1.2.3.4',
            11111,
            [1, 2, 3, 4, 5]
        );
        $array = iterator_to_array($generator);
        $this->assertSame(
            '1',
            $array[0]['value']
        );
        $this->assertSame(
            '-1',
            $array[1]['value']
        );
    }

    public function testUpdate()
    {
        $affectedRows = $this->voteByIpTable->update(
            1,
            '1.2.3.4',
            1,
            12345
        );
        $this->assertSame(
            0,
            $affectedRows
        );

        $this->voteByIpTable->insertOnDuplicateKeyUpdate(
            '1.2.3.4',
            1,
            12345,
            -1
        );
        $affectedRows = $this->voteByIpTable->update(
            1,
            '1.2.3.4',
            1,
            12345
        );
        $this->assertSame(
            1,
            $affectedRows
        );

        $affectedRows = $this->voteByIpTable->update(
            1,
            '1.2.3.4',
            1,
            12345
        );
        $this->assertSame(
            0,
            $affectedRows
        );
    }
}
