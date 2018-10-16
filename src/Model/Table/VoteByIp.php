<?php
namespace LeoGalleguillos\Vote\Model\Table;

use Exception;
use Generator;
use TypeError;
use Zend\Db\Adapter\Adapter;

class VoteByIp
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return int
     */
    public function insertOnDuplicateKeyUpdate(
        string $ip,
        int $entityTypeId,
        int $typeId,
        int $value
    ): int {
        $sql = '
            INSERT
              INTO `vote_by_ip` (
                       `ip`
                     , `entity_type_id`
                     , `type_id`
                     , `value`
                   )
            VALUES (?, ?, ?, ?)
                ON
         DUPLICATE
               KEY
            UPDATE `value` = ?
                 ;
        ';
        $parameters = [
            'ip'           => $ip,
            'entityTypeId' => $entityTypeId,
            'typeId'       => $typeId,
            'value'        => $value,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    /**
     * @throws TypeError
     */
    public function selectWhereIpEntityTypeIdTypeId(
        string $ip,
        int $entityTypeId,
        int $typeId
    ): array {
        $sql = '
            SELECT `vote_by_ip`.`value`
              FROM `vote_by_ip`
             WHERE `vote_by_ip`.`ip` = ?
               AND `vote_by_ip`.`entity_type_id` = ?
               AND `vote_by_ip`.`type_id` = ?
                 ;
        ';
        $parameters = [
            $userId,
            $entityTypeId,
            $typeId,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }
}
