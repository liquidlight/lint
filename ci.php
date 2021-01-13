#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

use App\Command\PhpCodingStandards;
use App\Command\CssStylelint;
use App\Command\JsEslint;
use App\Command\Lint;

$application = new Application();

// ... register commands
$application->add(new PhpCodingStandards(__DIR__));
$application->add(new CssStylelint(__DIR__));
$application->add(new JsEslint(__DIR__));
$application->add(new Lint(__DIR__));

$application->run();
