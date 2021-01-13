<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class JsEslint extends Base
{
	protected static $defaultName = 'js:eslint';

	protected function configure()
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Run ESLint')
			->setAliases(['js:lint'])
			->addOption(
				'fix',
				true,
				InputOption::VALUE_OPTIONAL,
				'Should the linter fix the code?',
				false
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$command = [
			$this->path . '/node_modules/.bin/eslint',
			getcwd(),
			'--color',
			'--cache',
			'--ext', '.js',
			'--config', $this->path . '/resources/config/Eslint.js',
			'--ignore-path', $this->path . '/resources/config/Eslint-Ignore',
			'--cache-location', $this->path . '/.cache/',
		];

		if ($input->getOption('fix') !== false) {
			$command[] = '--fix';
		}

		$process = new Process($command);
		$process->setTty(true);
		$process->run();

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
