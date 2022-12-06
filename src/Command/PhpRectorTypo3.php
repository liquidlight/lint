<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class PhpRectorTypo3 extends PhpRector
{
	protected static $defaultName = 'php:rector:typo3';

	protected function configure(): void
	{
		parent::configure();

		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Rector with TYPO3 presets')
			->addOption(
				't3-version',
				't',
				InputOption::VALUE_OPTIONAL,
				'What typo3 version would you like to text up to?',
				10,
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$version = (int)$input->getOption('t3-version');


		if (!is_file($this->getConfigPath('Typo3-' . $version))) {
			$this->io->error('There is no configuration file for TYPO3 ' . $version);
			return Command::FAILURE;
		}

		$this->io->info('Testing against TYPO3 version ' . $version);

		return $this->runRector(
			(array)$input->getArgument('paths'),
			$this->getConfigPath('Typo3-' . $version)
		);
	}
}
