<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class PhpRector extends Base
{
	protected static $defaultName = 'php:rector';

	protected function configure(): void
	{
		parent::configure();

		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Rector')
			->addArgument(
				'paths',
				InputArgument::IS_ARRAY,
				'What paths would you like to check',
				['./']
			)
		;
	}

	/**
	 * Run rector as a command
	 * @param array<string> $paths
	 * @param string $config
	 * @return int
	 */
	protected function runRector(array $paths = [], string $config): int
	{
		$fileCheck = $this->hasFiles('php');
		if (!$fileCheck) {
			return Command::SUCCESS;
		}

		$command = [
			$this->path . '/vendor/bin/rector',
			'process',
			'--config',
			$config,
			...$paths,
		];

		if ($this->input->getOption('fix') === false) {
			$command[] = '--dry-run';
		} else {
			$this->io->text('Attempting to fix...');
		}

		if ($this->output->isVeryVerbose()) {
			$command[] = '--debug';
		}

		if ($this->input->getOption('whisper')) {
			$command[] = '--quiet';
		}

		$process = $this->cmd($command);
		$this->io->newLine();
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}

	/**
	 * Get a rector config file
	 * @param string $name
	 * @return string
	 */
	protected function getConfigPath(string $name)
	{
		return $this->path . '/resources/config/Rector-' . $name . '.php';
	}
}
