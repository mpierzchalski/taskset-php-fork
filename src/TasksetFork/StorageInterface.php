<?php
/**
 * @package taskset
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */

namespace TasksetFork;


interface StorageInterface
{
    /**
     * Releases all data and remove
     *
     * @return array
     */
    public function release();
}