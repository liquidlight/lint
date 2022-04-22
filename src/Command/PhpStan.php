<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PhpStan extends Base
{
	protected static $defaultName = 'php:stan';

	protected function configure()
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('PHPStan')
			->addArgument(
				'paths',
				InputArgument::IS_ARRAY,
				'What paths would you like to check',
				['./']
			)
			->addOption(
				'level',
				'l',
				InputOption::VALUE_OPTIONAL,
				'What level should be used?',
				0,
			)
			;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$fileCheck = $this->hasFiles('php');
		if (!$fileCheck) {
			return Command::SUCCESS;
		}

		$this->getTitle();

		$command = [
			$this->path . '/vendor/bin/phpstan',
			'analyse',
			'--level',
			$input->getOption('level'),
			...$input->getArgument('paths'),
		];

		// if ($output->isVerbose() || $input->getOption('fix') || !Process::isTtySupported()) {
		// 	$command[] = '--verbose';
		// }

		// if ($output->isVeryVerbose()) {
		// 	$command[] = '--diff';
		// }

		// if ($input->getOption('fix') === false) {
		// 	$command[] = '--dry-run';
		// } else {
		// 	$this->io->text('Attempting to fix...');
		// }

		$process = $this->cmd($command);
		$this->io->newLine();
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
