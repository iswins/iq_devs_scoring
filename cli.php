#!/usr/bin/env php
<?php

use \Symfony\Component\Console\Application;

require_once __DIR__ . "/vendor/autoload.php";

$application = new Application();

$commandPath = __DIR__ . "/App/Commands";

$allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($commandPath));
$phpFiles = new RegexIterator($allFiles, '/\.php$/');
/** @var \SplFileInfo $phpFile */
foreach ($phpFiles as $phpFile) {
    $fileName = $phpFile->getRealPath();
    $fileName = str_replace([__DIR__, '.php'] , "", $fileName);
    $className = str_replace("/", '\\', $fileName);
    $application->add(new $className());
}

//Запускаем приложение на исполнение.
$application->run();
