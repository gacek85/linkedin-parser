#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Gacek85\LinkedInCrawler\Commands\CommandsLoader;
use Symfony\Component\Console\Application;

/**
 *  Simple console tool
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
if (php_sapi_name() !== 'cli') { // Ban calls outside the console
    die ('Cannot invoke commands outside the console!');
}

$commands_loader = new CommandsLoader(sprintf(
    '%s/Commands',
    __DIR__
));

$application = new Application();
foreach ($commands_loader->getCommands() as $command) {
    $application->add($command);
}

$application->run();


