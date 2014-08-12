<?php
/**
 * @package taskset
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */

namespace TasksetFork\Storage;


use Predis\Client;
use TasksetFork\StorageAdapterInterface;

class Redis implements StorageAdapterInterface
{
    /**
     * @var Client
     */
    private $redis;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->redis = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->redis->set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }

} 