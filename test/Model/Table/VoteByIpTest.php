<?php
namespace LeoGalleguillos\VoteTest\Model\Table;

use LeoGalleguillos\Vote\Model\Table as VoteTable;
use LeoGalleguillos\VoteTest\TableTestCase;
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
}
