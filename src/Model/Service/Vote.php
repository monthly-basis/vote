<?php
namespace LeoGalleguillos\Vote\Model\Service;

use LeoGalleguillos\Vote\Model\Table as VoteTable;

class Vote
{
    public function __construct(
        VoteTable\Vote $voteTable
    ) {
        $this->voteTable = $voteTable;
    }
}
