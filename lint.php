#!/usr/bin/env php
<?php
// application.php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

use App\Command\JsEslint;
use App\Command\JsonLint;
use App\Command\PhpCodingStandards;
use App\Command\PhpStan;
use App\Command\Run;
use App\Command\ScssStylelint;
use App\Command\TSLint;
use App\Command\Update;
use App\Command\YamlLint;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$application = new Application();

$application->add(new JsEslint(__DIR__));
$application->add(new JsonLint(__DIR__));
$application->add(new PhpCodingStandards(__DIR__));
$application->add(new PhpStan(__DIR__));
$application->add(new Run(__DIR__));
$application->add(new ScssStylelint(__DIR__));
$application->add(new TSLint(__DIR__));
$application->add(new Update(__DIR__));
$application->add(new YamlLint(__DIR__));

$application->run();
