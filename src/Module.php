<?php
namespace LeoGalleguillos\Vote;

use LeoGalleguillos\Vote\Model\Service as VoteService;
use LeoGalleguillos\Vote\Model\Table as VoteTable;

class Module
{
    public function getConfig()
    {
        return [
            'view_helpers' => [
                'aliases' => [
                ],
                'factories' => [
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                VoteTable\Vote::class => function ($serviceManager) {
                    return new VoteTable\Vote(
                        $serviceManager->get('main')
                    );
                },
            ],
        ];
    }
}
