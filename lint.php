#!/usr/bin/env php
<?php
// application.php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

use App\Command\ComposerNormalize;
use App\Command\JsEslint;
use App\Command\JsonLint;
use App\Command\PhpCodingStandards;
use App\Command\PhpRector;
use App\Command\PhpRectorTypo3;
use App\Command\PhpStan;
use App\Command\Run;
use App\Command\ScssStylelint;
use App\Command\TSLint;
use App\Command\SelfUpdate;
use App\Command\YamlLint;
use Symfony\Component\Translation\Command\XliffLintCommand;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$composerFile = json_decode(file_get_contents(__DIR__ . '/composer.json') ?: '');

$application = new Application(
	$composerFile->description,
	$composerFile->version
);

$application->add(new ComposerNormalize(__DIR__));
$application->add(new JsEslint(__DIR__));
$application->add(new JsonLint(__DIR__));
$application->add(new PhpCodingStandards(__DIR__));
$application->add(new PhpRector(__DIR__));
$application->add(new PhpRectorTypo3(__DIR__));
$application->add(new PhpStan(__DIR__));
$application->add(new Run(__DIR__));
$application->add(new ScssStylelint(__DIR__));
$application->add(new TSLint(__DIR__));
$application->add(new SelfUpdate(__DIR__));
$application->add(new YamlLint(__DIR__));
$application->add((new XliffLintCommand())->setName('xliff:lint')->setAliases(['lint:xliff']));

$application->run();
