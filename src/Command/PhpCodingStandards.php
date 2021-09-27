<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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
			->setDescription('PHP Coding Standards')
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
		parent::execute($input, $output);

		$fileCheck = $this->findFiles('php');
		if (!$fileCheck) {
			return Command::SUCCESS;
		}

		$this->getTitle();

		$command = [
			$this->path . '/vendor/bin/php-cs-fixer',
			'fix',
			'--config=' . $this->path . '/resources/config/PHPCodingStandards.php',
		];

		if ($output->isVerbose() || $input->getOption('fix') || !Process::isTtySupported()) {
			$command[] = '--verbose';
		}

		if ($output->isVeryVerbose()) {
			$command[] = '--diff';
		}

		if ($input->getOption('fix') === false) {
			$command[] = '--dry-run';
		} else {
			$this->io->text('Attempting to fix...');
		}

		$process = $this->cmd($command);
		$this->io->newLine();
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
