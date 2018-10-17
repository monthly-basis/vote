<?php
namespace LeoGalleguillos\Vote\Model\Entity;

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
