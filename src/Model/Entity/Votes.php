<?php
namespace LeoGalleguillos\Model\Entity\Vote;

use Exception;

class Votes
{
    protected $count[];

    public function getCount(int $value) : int
    {
        if (!isset($this->count[$key])) {
            throw new Except('Key value pair not set.');
        }

        return $this->count[$key];
    }

    public function setCount(int $key, int $value)
    {
        $this->count[$key] = $value;
        return $this;
    }
}
