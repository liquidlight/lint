<?php

namespace LiquidLight\Rector\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PhpRectorCommand extends RectorCommand
{
	protected function configure(): void
	{
		parent::configure();

		$this
			->setName('php:rector')
			// the short description shown while running "php bin/console list"
			->setDescription('Check your PHP code')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		parent::execute($input, $output);


		return $this->runRector('PHP');
	}
}
