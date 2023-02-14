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

	protected function configure(): void
	{
		parent::configure();

		$this
			// the short description shown while running "php bin/console list"
			->setDescription('ESLint')
			->setAliases(['js:lint'])
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$ignore = explode(
			PHP_EOL,
			file_get_contents($this->path . '/resources/config/Eslint-Ignore') ?: ''
		);
		$fileCheck = $this->hasFiles('js', $ignore);
		if (!$fileCheck) {
			return Command::SUCCESS;
		}

		$command = [
			$this->path . '/node_modules/.bin/eslint',
			getcwd(),
			'--color',
			'--cache',
			'--ext', '.js',
			'--config', $this->path . '/resources/config/Eslint.js',
			'--ignore-path', $this->path . '/resources/config/Eslint-Ignore',
			'--cache-location', $this->path . '/.cache/',
			'--cache-strategy', 'content',
		];

		if ($this->input->getOption('fix') !== false) {
			$command[] = '--fix';

			$this->io->text('Attempting to fix...');
		}

		$process = $this->cmd($command);
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
