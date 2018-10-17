<?php
namespace LeoGalleguillos\Vote\Model\Entity\Vote;

use LeoGalleguillos\Vote\Model\Entity as VoteEntity;

class ByIp extends VoteEntity\Vote
{
    /**
     * @var int
     */
    protected $value;

    public function getValue() : int
    {
        return $this->value;
    }

    public function setValue(int $value) : VoteEntity\Vote
    {
        $this->value = $value;
        return $this;
    }
}
