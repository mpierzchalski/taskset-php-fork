<?php
/**
 * @package taskset
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */

namespace TasksetFork;

use PHPFork\Fork;
use PHPFork\Subscriber;
use TasksetFork\PHPFork\Subscriber\TestsetForkSubscriber;

class TasksetFork
{

    /**
     * @var Fork
     */
    private $fork;

    /**
     * @var \ArrayIterator
     */
    private $tasks;

    /**
     * @var Storage
     */
    private $storage;

    /**
     * @param StorageAdapterInterface   $storageAdapter
     * @param array                     $tasks
     * @param int                       $maxParallelTasks [optional]
     * @param int                       $limitExecutionTime [optional]
     */
    public function __construct(
        StorageAdapterInterface $storageAdapter,
        $tasks,
        $maxParallelTasks = null,
        $limitExecutionTime = 15
    ) {
        $this->storage = new Storage($storageAdapter, $tasks);
        $this->tasks   = $tasks;

        if ($maxParallelTasks === null) {
            $maxParallelTasks = count($tasks);
        }
        $this->fork  = new Fork($maxParallelTasks, $limitExecutionTime);
        $this->registerSubscriber(new TestsetForkSubscriber($this->storage));
    }

    /**
     * Registers subscriber
     *
     * @param Subscriber $subscriber
     */
    public function registerSubscriber(Subscriber $subscriber)
    {
        $this->fork->registerSubscriber($subscriber);
    }

    /**
     * Executes tasks
     *
     * @return array
     */
    public function execute()
    {
        $this->fork->executeCollection($this->tasks);
        return $this->storage->release();
    }
} 