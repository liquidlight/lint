<?php

namespace LiquidLight\PhpStan\Command;

use LiquidLight\Linter\Command\Base;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PhpStanCommand extends Base
{
	protected static $defaultName = 'php:stan';

	protected function configure(): void
	{
		parent::configure();

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
		$extPath = dirname(__DIR__) . '/..';

		$fileCheck = $this->hasFiles('php');
		if (!$fileCheck) {
			return Command::SUCCESS;
		}

		$paths = (array)$input->getArgument('paths');

		$command = [
			PHP_BINARY,
			$this->path . '/vendor/bin/phpstan',
			'analyse',
			'--level',
			$this->input->getOption('level'),
			'--configuration',
			$extPath . '/resources/config/PHPStan.neon',
			...$paths,
		];

		if ($output->isVeryVerbose()) {
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
}
