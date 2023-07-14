#!/usr/bin/env php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';

use App\Command\Run;
use App\Command\SelfUpdate;
use App\Command\PackageLint;
use App\Command\ScssStylelint;
use Symfony\Component\Console\Application;
use LiquidLight\PhpStan\Command\PhpStanCommand;
use LiquidLight\Rector\Command\PhpRectorCommand;
use LiquidLight\JsonLint\Command\JsonLintCommand;
use LiquidLight\YamlLint\Command\YamlLintCommand;
use LiquidLight\Eslint\Command\EslintCommand;
use LiquidLight\Rector\Command\PhpRectorTypo3Command;
use Symfony\Component\Translation\Command\XliffLintCommand;
use LiquidLight\EditorConfig\Command\EditorconfigLintCommand;
use LiquidLight\TypoScriptLint\Command\TypoScriptLintCommand;
use LiquidLight\ComposerNormalize\Command\ComposerNormalizeCommand;
use LiquidLight\PhpCodingStandards\Command\PhpCodingStandardsCommand;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/** @var array<string> $composerFile */
$composerFile = json_decode(file_get_contents(__DIR__ . '/composer.json') ?: '', true);

$application = new Application(
	$composerFile['description'],
	$composerFile['version']
);

$application->add((new ComposerNormalizeCommand(__DIR__))->setAliases(['composer:lint']));
$application->add(new EditorconfigLintCommand(__DIR__));
$application->add((new EslintCommand(__DIR__))->setAliases(['js:lint']));
$application->add((new JsonLintCommand(__DIR__)));
$application->add((new PackageLint(__DIR__)));
$application->add((new PhpCodingStandardsCommand(__DIR__))->setAliases(['php:cs', 'php:lint', 'php']));
$application->add((new PhpRectorCommand(__DIR__)));
$application->add((new PhpRectorTypo3Command(__DIR__)));
$application->add((new PhpStanCommand(__DIR__)));
$application->add((new Run(__DIR__)));
$application->add((new ScssStylelint(__DIR__)));
$application->add((new TypoScriptLintCommand(__DIR__))->setAliases(['typoscript:lint']));
$application->add((new SelfUpdate(__DIR__)));
$application->add((new YamlLintCommand(__DIR__)));
$application->add((new XliffLintCommand())->setName('xliff:lint')->setAliases(['lint:xliff']));

$application->run();
