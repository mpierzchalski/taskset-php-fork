<?php
/**
 * @package taskset
 * @author  Michał Pierzchalski <michal.pierzchalski@gmail.com>
 * @license MIT
 */

require_once(dirname(__FILE__) . '/../vendor/autoload.php');

$src = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src');
spl_autoload_register(function ($class) use ($src) {
    $filename = $src . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (is_readable($filename)) {
        include $filename;
    }
});

$stack = [
    'http://www.wp.pl',
    'http://www.onet.pl',
    'https://www.inseco.pl',
    'http://www.pudelek.pl',
    'http://www.biztok.pl'
];

$collection = [];
foreach ($stack as &$site) {
    $collection[] = function () use ($site) {
        $beginsAt   = date('c');
        $time       = rand(1,9);
        sleep($time);
        print $site . ' => Begins at: ' . $beginsAt . '; executed in: ' . (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . PHP_EOL;
        return $site . ' => ' . $time;
    };

}

$predisOptions = ['prefix' => 'mp-php-fork'];
$predisClient  = new Predis\Client('tcp://127.0.0.1:6379?database=10', $predisOptions);
$storage       = new \TasksetFork\Storage\Redis($predisClient);

$taskset = new \TasksetFork\TasksetFork($storage, $collection);
var_dump($taskset->execute());
