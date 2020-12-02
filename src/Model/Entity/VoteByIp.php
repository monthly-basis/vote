<?php
namespace MonthlyBasis\Vote\Model\Entity;

use MonthlyBasis\Vote\Model\Entity as VoteEntity;

class VoteByIp
{
    /**
     * @var int
     */
    protected $value;

    public function getValue() : int
    {
        return $this->value;
    }

    public function setValue(int $value) : VoteEntity\VoteByIp
    {
        $this->value = $value;
        return $this;
    }
}
