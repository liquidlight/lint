<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PhpCodingStandards extends Base
{
	protected static $defaultName = 'php:coding-standards';

	protected function configure()
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Run PHP Code Standards')
			->setAliases(['php:cs', 'php:lint'])
			->addOption(
				'fix',
				'',
				InputOption::VALUE_NONE,
				'Should the linter fix the code?'
			)
			;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$command = [
			$this->path . '/vendor/bin/php-cs-fixer',
			'fix',
			'--config=' . $this->path . '/resources/config/PHPCodingStandards.php',
		];

		if ($output->isVerbose()) {
			$command[] = '--verbose';
		}

		if ($output->isVeryVerbose()) {
			$command[] = '--diff';
		}

		if ($input->getOption('fix') === false) {
			$command[] = '--dry-run';
		}

		$process = $this->cmd($command);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
