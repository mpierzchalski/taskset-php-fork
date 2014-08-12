<?php
/**
 * @package taskset
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */

namespace TasksetFork;


class Storage implements StorageInterface, StorageAdapterInterface
{

    /**
     * Storage key format
     */
    const STORAGE_KEY_FORMAT = '__TasksetFork[%s][%s]';

    /**
     * @var string
     */
    private $token;

    /**
     * @var array
     */
    private $tasksKeys = [];

    /**
     * @param StorageAdapterInterface $adapter
     * @param array                   $tasks
     */
    public function __construct(StorageAdapterInterface $adapter, $tasks)
    {
        $this->adapter = $adapter;
        $this->token   = md5(microtime(true));

        $this->tasksKeys = array_combine(
            array_keys($tasks),
            array_map(function ($key) {
                return $this->convertKeyToToken($key);
            }, array_keys($tasks))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->adapter->set($this->convertKeyToToken($key), $value);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->adapter->get($this->convertKeyToToken($key));
    }

    /**
     * {@inheritdoc}
     */
    public function release()
    {
        //todo: removing released values

        $result = [];
        foreach ($this->tasksKeys as $key => $taskKey) {
            $result[$key] = $this->adapter->get($taskKey);
        }
        return $result;
    }

    /**
     * @param string $key
     * @return string
     */
    private function convertKeyToToken($key)
    {
        return sprintf(self::STORAGE_KEY_FORMAT, $this->token, $key);
    }

}