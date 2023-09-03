#!/usr/bin/env php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';

use LiquidLight\Linter\Command\Run;
use LiquidLight\Linter\Command\SelfUpdate;
use LiquidLight\ComposerNormalize\Command\ComposerNormalizeCommand;
use LiquidLight\EditorConfig\Command\EditorconfigLintCommand;
use LiquidLight\Eslint\Command\EslintCommand;
use LiquidLight\JsonLint\Command\JsonLintCommand;
use LiquidLight\PhpCodingStandards\Command\PhpCodingStandardsCommand;
use LiquidLight\PhpStan\Command\PhpStanCommand;
use LiquidLight\Rector\Command\PhpRectorCommand;
use LiquidLight\Rector\Command\PhpRectorTypo3Command;
use LiquidLight\Stylelint\Command\StylelintCommand;
use LiquidLight\TypoScriptLint\Command\TypoScriptLintCommand;
use LiquidLight\YamlLint\Command\YamlLintCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Translation\Command\XliffLintCommand;

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
$application->add((new PhpCodingStandardsCommand(__DIR__))->setAliases(['php:cs', 'php:lint', 'php']));
$application->add((new PhpRectorCommand(__DIR__)));
$application->add((new PhpRectorTypo3Command(__DIR__)));
$application->add((new PhpStanCommand(__DIR__)));
$application->add((new Run(__DIR__)));
$application->add((new StylelintCommand(__DIR__))->setAliases(['scss:lint', 'css:lint']));
$application->add((new TypoScriptLintCommand(__DIR__))->setAliases(['typoscript:lint']));
$application->add((new SelfUpdate(__DIR__)));
$application->add((new YamlLintCommand(__DIR__)));
$application->add((new XliffLintCommand())->setName('xliff:lint')->setAliases(['lint:xliff']));

$application->run();
