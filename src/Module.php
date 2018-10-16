<?php
namespace LeoGalleguillos\Vote;

use LeoGalleguillos\Vote\Model\Factory as VoteFactory;
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
                VoteFactory\Vote::class => function ($serviceManager) {
                    return new VoteFactory\Vote(
                        $serviceManager->get(VoteTable\Vote::class)
                    );
                },
                VoteService\ByIp\UpVote::class => function ($serviceManager) {
                    return new VoteService\ByIp\UpVote(
                        $serviceManager->get('vote')->getDriver()->getConnection(),
                        $serviceManager->get(VoteTable\VoteByIp::class),
                        $serviceManager->get(VoteTable\Votes::class)
                    );
                },
                VoteService\ByIp\UpVote\Remove::class => function ($serviceManager) {
                    return new VoteService\ByIp\UpVote\Remove(
                        $serviceManager->get(VoteTable\VoteByIp::class),
                        $serviceManager->get(VoteTable\Votes::class)
                    );
                },
                VoteService\Vote::class => function ($serviceManager) {
                    return new VoteService\Vote(
                        $serviceManager->get(VoteTable\Vote::class)
                    );
                },
                VoteTable\Vote::class => function ($serviceManager) {
                    return new VoteTable\Vote(
                        $serviceManager->get('vote')
                    );
                },
                VoteTable\VoteByIp::class => function ($serviceManager) {
                    return new VoteTable\VoteByIp(
                        $serviceManager->get('vote')
                    );
                },
                VoteTable\Votes::class => function ($serviceManager) {
                    return new VoteTable\Votes(
                        $serviceManager->get('vote')
                    );
                },
            ],
        ];
    }
}
