<?php

use Nip\Cache\Stores\Repository;
use Nip\Container\Container;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

define('PROJECT_BASE_PATH', __DIR__ . '/..');
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'fixtures');

require dirname(__DIR__) . '/vendor/autoload.php';

Container::setInstance(new Container());

$cachePath = TEST_FIXTURE_PATH . '/storage/cache';
array_map(function ($path) {
    if (is_file($path)) {
        unlink($path);
    }
}, glob($cachePath . '/@/*'));

$adapter = new FilesystemAdapter('', 600, $cachePath);
$store = new Repository($adapter);
$store->clear();
Container::getInstance()->set('cache.store', $store);

