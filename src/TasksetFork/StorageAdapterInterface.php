<?php
/**
 * @package taskset
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */

namespace TasksetFork;


interface StorageAdapterInterface
{
    /**
     * Sets data to storage
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value);

    /**
     * Gets data by index
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key);
}