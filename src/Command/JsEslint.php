<?php

// src/Command/CreateUserCommand.php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputOption;

class JsEslint extends Base
{
	protected static $defaultName = 'js:eslint';

	protected function configure()
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('ESLint')
			->setAliases(['js:lint'])
			->addOption(
				'fix',
				true,
				InputOption::VALUE_NONE,
				'Should the linter fix the code?'
			)
			;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$ignore = explode(PHP_EOL, file_get_contents($this->path . '/resources/config/Eslint-Ignore'));
		$fileCheck = $this->findFiles('js', $ignore);
		if(!$fileCheck) {
			return Command::SUCCESS;
		}

		$this->getTitle();

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

			$this->io->text('Attempting to fix...');
		}

		$process = $this->cmd($command);
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
