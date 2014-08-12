<?php
/**
 * @package taskset
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */

namespace TasksetFork\PHPFork\Subscriber;


use PHPFork\Handler\ExecResultsHandler;
use PHPFork\Handler\PidResultsHandler;
use PHPFork\Subscriber;
use TasksetFork\Storage;

class TestsetForkSubscriber extends Subscriber
{
    /**
     * @var \TasksetFork\Storage
     */
    private $storage;

    /**
     * @param Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * {@inheritdoc}
     */
    public function killPid(PidResultsHandler $resultHandler)
    {
        $this->storage->set($resultHandler->getPidCustomKey(), $resultHandler->getExecute());
    }

} 