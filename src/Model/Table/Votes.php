<?php
namespace LeoGalleguillos\Vote\Model\Table;

use Exception;
use Generator;
use TypeError;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Exception\InvalidQueryException;

class Votes
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
     * @throws InvalidQueryException `down_votes` column is unsigned int and
     *                               cannot be decremented below 0
     */
    public function decrementDownVotes(
        int $entityTypeId,
        int $typeId
    ):int {
        $sql = '
            UPDATE `votes`
               SET `down_votes` = `down_votes` - 1
             WHERE `entity_type_id` = ?
               AND `type_id` = ?
        ';
        $parameters = [
            $entityTypeId,
            $typeId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    /**
     * @throws InvalidQueryException `up_votes` column is unsigned int and
     *                               cannot be decremented below 0
     */
    public function decrementUpVotes(
        int $entityTypeId,
        int $typeId
    ):int {
        $sql = '
            UPDATE `votes`
               SET `up_votes` = `up_votes` - 1
             WHERE `entity_type_id` = ?
               AND `type_id` = ?
        ';
        $parameters = [
            $entityTypeId,
            $typeId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    public function incrementDownVotes(
        int $entityTypeId,
        int $typeId
    ):int {
        $sql = '
            UPDATE `votes`
               SET `down_votes` = `down_votes` + 1
             WHERE `entity_type_id` = ?
               AND `type_id` = ?
        ';
        $parameters = [
            $entityTypeId,
            $typeId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    public function incrementUpVotes(
        int $entityTypeId,
        int $typeId
    ):int {
        $sql = '
            UPDATE `votes`
               SET `up_votes` = `up_votes` + 1
             WHERE `entity_type_id` = ?
               AND `type_id` = ?
        ';
        $parameters = [
            $entityTypeId,
            $typeId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    public function insertIgnore(
        int $entityTypeId,
        int $typeId
    ): int {
        $sql = '
            INSERT IGNORE
              INTO `votes` (
                       `entity_type_id`
                     , `type_id`
                   )
            VALUES (?, ?)
                 ;
        ';
        $parameters = [
            $entityTypeId,
            $typeId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    public function select(
        int $entityTypeId,
        int $typeId
    ): array {
        $sql = '
            SELECT `entity_type_id`
                 , `type_id`
                 , `up_votes`
                 , `down_votes`
              FROM `votes`
             WHERE `entity_type_id` = ?
               AND `type_id` = ?
                 ;
        ';
        $parameters = [
            $entityTypeId,
            $typeId,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->current();
    }

    public function selectWhereEntityTypeIdAndTypeIdIn(
        int $entityTypeId,
        array $typeIds
    ): Generator {
        $typeIds = array_map('intval', $typeIds);
        $typeIds = implode(', ', $typeIds);

        $sql = "
            SELECT `entity_type_id`
                 , `type_id`
                 , `up_votes`
                 , `down_votes`
              FROM `votes`
             WHERE `votes`.`entity_type_id` = ?
               AND `votes`.`type_id` IN ($typeIds)
             ORDER
                BY FIELD(`votes`.`type_id`, $typeIds)
                 ;
        ";

        $parameters = [
            $entityTypeId,
        ];

        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
