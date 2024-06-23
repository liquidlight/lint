<?php

namespace LintKit\PhpCodingStandards\Command;

use LintKit\Base\Command\Base;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PhpCodingStandardsCommand extends Base
{
	protected function configure(): void
	{
		parent::configure();

		$this
			->setName('php:coding-standards')
			// the short description shown while running "php bin/console list"
			->setDescription('PHP Coding Standards')
			->addOption(
				'clean',
				'',
				InputOption::VALUE_NONE,
				'Delete the cache file and do a clean scan',
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		parent::execute($input, $output);
		$extPath = dirname(__DIR__) . '/..';

		if ($this->input->getOption('clean')) {
			$this->io->text('Deleting cache file');
			unlink($this->path . '/.cache/.phpcscache_' . md5($GLOBALS['_SERVER']['PWD']));
		}

		$fileCheck = $this->hasFiles('php');
		if (!$fileCheck) {
			return Command::SUCCESS;
		}

		$command = [
			PHP_BINARY,
			$this->path . '/vendor/bin/php-cs-fixer',
			'fix',
			'--config=' . $extPath . '/resources/config/PHPCodingStandards.php',
		];

		if ($this->input->getOption('whisper')) {
			$command[] = '--quiet';
		}

		if ($output->isVerbose() || $this->input->getOption('fix') || !Process::isTtySupported()) {
			$command[] = '--verbose';
		}

		if ($output->isVeryVerbose()) {
			$command[] = '--diff';
		}

		if ($this->input->getOption('fix') === false) {
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
