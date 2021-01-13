#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

use App\Command\PhpCodingStandards;
use App\Command\ScssStylelint;
use App\Command\JsEslint;
use App\Command\Lint;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$application = new Application();

$application->add(new PhpCodingStandards(__DIR__));
$application->add(new ScssStylelint(__DIR__));
$application->add(new JsEslint(__DIR__));
$application->add(new Lint(__DIR__));

$application->run();
