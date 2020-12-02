<?php
namespace MonthlyBasis\Vote\Model\Entity;

use MonthlyBasis\Vote\Model\Entity as VoteEntity;

class Votes
{
    protected $downVotes;
    protected $upVotes;

    public function getDownVotes(): int
    {
        return $this->downVotes;
    }

    public function setDownVotes(int $downVotes): VoteEntity\Votes
    {
        $this->downVotes = $downVotes;
        return $this;
    }

    public function getUpVotes(): int
    {
        return $this->upVotes;
    }

    public function setUpVotes(int $upVotes): VoteEntity\Votes
    {
        $this->upVotes = $upVotes;
        return $this;
    }
}
