<?php

// src/Command/CreateUserCommand.php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ComposerNormalize extends Base
{
	protected static $defaultName = 'composer:normalize';

	protected function configure(): void
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Composer Normalize')
			->setAliases(['composer:lint'])
			->addOption(
				'fix',
				'f',
				InputOption::VALUE_NONE,
				'Should the linter fix the code?',
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$command = [
			$this->path . '/bin/composer-normalize.phar',
			getcwd() . '/composer.json',
			'--indent-size', '1',
			'--indent-style', 'tab',
		];

		if ($output->isVerbose()) {
			$command[] = '-v';
		}

		if ($input->getOption('fix') === false) {
			$command[] = '--dry-run';
		}

		$process = $this->cmd($command);
		$this->io->newLine();
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}