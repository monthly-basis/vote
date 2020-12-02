<?php
namespace MonthlyBasis\Vote;

use MonthlyBasis\Vote\Model\Factory as VoteFactory;
use MonthlyBasis\Vote\Model\Service as VoteService;
use MonthlyBasis\Vote\Model\Table as VoteTable;

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
                VoteFactory\VoteByIp::class => function ($serviceManager) {
                    return new VoteFactory\VoteByIp(
                        $serviceManager->get(VoteTable\VoteByIp::class)
                    );
                },
                VoteFactory\Votes::class => function ($serviceManager) {
                    return new VoteFactory\Votes(
                        $serviceManager->get(VoteTable\Votes::class)
                    );
                },
                VoteService\Vote::class => function ($serviceManager) {
                    return new VoteService\Vote(
                        $serviceManager->get(VoteTable\Vote::class)
                    );
                },
                VoteService\VoteByIp\Multiple::class => function ($serviceManager) {
                    return new VoteService\VoteByIp\Multiple(
                        $serviceManager->get(VoteFactory\VoteByIp::class),
                        $serviceManager->get(VoteTable\VoteByIp::class)
                    );
                },
                VoteService\VoteByIp\DownVote::class => function ($serviceManager) {
                    return new VoteService\VoteByIp\DownVote(
                        $serviceManager->get('vote')->getDriver()->getConnection(),
                        $serviceManager->get(VoteTable\VoteByIp::class),
                        $serviceManager->get(VoteTable\Votes::class)
                    );
                },
                VoteService\VoteByIp\DownVote\Remove::class => function ($serviceManager) {
                    return new VoteService\VoteByIp\DownVote\Remove(
                        $serviceManager->get('vote')->getDriver()->getConnection(),
                        $serviceManager->get(VoteTable\VoteByIp::class),
                        $serviceManager->get(VoteTable\Votes::class)
                    );
                },
                VoteService\VoteByIp\UpVote::class => function ($serviceManager) {
                    return new VoteService\VoteByIp\UpVote(
                        $serviceManager->get('vote')->getDriver()->getConnection(),
                        $serviceManager->get(VoteTable\VoteByIp::class),
                        $serviceManager->get(VoteTable\Votes::class)
                    );
                },
                VoteService\VoteByIp\UpVote\Remove::class => function ($serviceManager) {
                    return new VoteService\VoteByIp\UpVote\Remove(
                        $serviceManager->get('vote')->getDriver()->getConnection(),
                        $serviceManager->get(VoteTable\VoteByIp::class),
                        $serviceManager->get(VoteTable\Votes::class)
                    );
                },
                VoteService\Votes\Multiple::class => function ($serviceManager) {
                    return new VoteService\Votes\Multiple(
                        $serviceManager->get(VoteFactory\Votes::class),
                        $serviceManager->get(VoteTable\Votes::class)
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
