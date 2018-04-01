<?php
namespace LeoGalleguillos\Model\Entity;

use LeoGalleguillos\Model\Entity\Vote as VoteEntity;

class Vote
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
