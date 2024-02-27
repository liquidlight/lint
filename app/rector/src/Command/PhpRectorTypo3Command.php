<?php

namespace LiquidLight\Rector\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class PhpRectorTypo3Command extends RectorCommand
{
	protected function configure(): void
	{
		parent::configure();

		$this
			->setName('php:rector:typo3')
			// the short description shown while running "php bin/console list"
			->setDescription('Rector with TYPO3 presets')
			->addOption(
				'typo3-version',
				't',
				InputOption::VALUE_OPTIONAL,
				'What TYPO3 versions would you check against?',
				11,
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		parent::execute($input, $output);

		$typo3Version = (string)$this->input->getOption('typo3-version');
		return $this->runRector('Typo3-' . $typo3Version);
	}
}
