<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CssStylelint extends Base
{
	protected static $defaultName = 'css:stylelint';

	protected function configure()
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Run Stylelint')
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
			$this->path . '/node_modules/.bin/stylelint',
			getcwd() . '/build/*/css/**/*.scss',
			'--color',
			'--cache',
			'--config', $this->path . '/resources/config/Stylelint.json',
			'--config-basedir', $this->path . '/node_modules/',
			'--ignore-path', $this->path . '/resources/config/Stylelint-Ignore',
			'--cache-location', $this->path . '/.cache/',
		];

		if($input->getOption('fix') !== false) {
			$command[] = '--fix';
		}

		$process = new Process($command);
		$process->setTty(true);
		$process->run();

		echo $process->getOutput();

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}

}
