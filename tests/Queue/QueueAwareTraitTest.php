<?php

namespace SlmQueueTest\Queue;

use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase as TestCase;
use SlmQueue\Job\JobPluginManager;
use SlmQueueTest\Asset\QueueAwareTraitJob;
use SlmQueueTest\Asset\SimpleQueue;

class QueueAwareTraitTest extends TestCase
{
    /**
     * @var QueueAwareTraitJob $traitObject
     */
    private $job;

    public function setUp(): void
    {
        if (version_compare(phpversion(), '5.4', 'lt')) {
            $this->markTestSkipped(
                'Traits are not available in php53.'
            );

            return;
        }

        $this->job = new QueueAwareTraitJob();
    }

    public function testDefaultGetter()
    {
        static::assertNull($this->job->getQueue());
    }

    public function testSetter()
    {
        $serviceManager = new ServiceManager();
        $jobPluginManager = new JobPluginManager($serviceManager);
        $queue = new SimpleQueue('name', $jobPluginManager);
        $this->job->setQueue($queue);

        static::assertNotNull($this->job->getQueue());
        static::assertEquals($queue, $this->job->getQueue());
    }
}
