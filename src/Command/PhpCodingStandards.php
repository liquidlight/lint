<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Process\Process;

class PhpCodingStandards extends Base
{
	protected static $defaultName = 'php:coding-standards';

	protected function configure(): void
	{
		parent::configure();

		$this
			// the short description shown while running "php bin/console list"
			->setDescription('PHP Coding Standards')
			->setAliases(['php:cs', 'php:lint', 'php'])
			->addOption(
				'clean',
				'',
				InputOption::VALUE_NONE,
				'Delete the cache file and do a clean scan',
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		if ($input->getOption('clean')) {
			$this->io->text('Deleting cache file');
			unlink($this->path . '/.cache/.phpcscache_' . md5($GLOBALS['_SERVER']['PWD']));
		}

		$fileCheck = $this->hasFiles('php');
		if (!$fileCheck) {
			return Command::SUCCESS;
		}

		$command = [
			$this->path . '/vendor/bin/php-cs-fixer',
			'fix',
			'--config=' . $this->path . '/resources/config/PHPCodingStandards.php',
		];

		if ($input->getOption('whisper')) {
			$command[] = '--quiet';
		}

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
