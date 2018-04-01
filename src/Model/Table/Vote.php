<?php
namespace LeoGalleguillos\Vote\Model\Table;

use Exception;
use Generator;
use Zend\Db\Adapter\Adapter;

class Vote
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
        int $userId,
        int $entityId = null,
        int $entityTypeId,
        int $typeId,
        int $value
    ) : int {
        $sql = '
            INSERT
              INTO `vote` (
                  `user_id`, `entity_id`,
                  `entity_type_id`, `type_id`, `value`, `created`
                   )
            VALUES (:userId, :entityId, :entityTypeId, :typeId, :value, UTC_TIMESTAMP())
                ON DUPLICATE KEY UPDATE `value` = :value, `updated` = UTC_TIMESTAMP()
                 ;
        ';
        $parameters = [
            'userId'       => $userId,
            'entityId'     => $entityId,
            'entityTypeId' => $entityTypeId,
            'typeId'       => $typeId,
            'value'        => $value,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }

    public function selectCount()
    {
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `vote`
                 ;
        ';
        $row = $this->adapter->query($sql)->execute()->current();
        return (int) $row['count'];
    }

    public function selectCountWhereEntityTypeIdTypeIdValue(
        int $entityTypeId,
        int $typeId,
        int $value
    ) {
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `vote`
             WHERE `entity_type_id` = :entityTypeId
               AND `type_id` = :typeId
               AND `value` = :value
                 ;
        ';
        $parameters = [
            'entityTypeId' => $entityTypeId,
            'typeId'       => $typeId,
            'value'        => $value,
        ];
        $row = $this->adapter->query($sql)->execute($parameters)->current();
        return (int) $row['count'];
    }

    /**
     * @throws Exception
     */
    public function selectWhereUserIdEntityTypeIdTypeId(
        int $userId,
        int $entityTypeId,
        int $typeId
    ) : array {
        $sql = '
            SELECT `vote`.`value`
              FROM `vote`
             WHERE `vote`.`user_id` = :userId
               AND `entity_type_id` = :entityTypeId
               AND `type_id` = :typeId
                 ;
        ';
        $parameters = [
            'userId'       => $userId,
            'entityTypeId' => $entityTypeId,
            'typeId'       => $typeId,
        ];
        $row = $this->adapter->query($sql)->execute($parameters)->current();

        if (empty($row)) {
            throw new Except('Matching row could not be found');
        }

        return $row;
    }
}
