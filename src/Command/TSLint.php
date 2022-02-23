<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class TSLint extends Base
{
	protected static $defaultName = 'ts:lint';

	protected function configure()
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Typoscript Lint')
			->setAliases(['typoscript:lint'])
			;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$command = [
			$this->path . '/vendor/bin/typoscript-lint',
			'--config=' . $this->path . '/resources/config/TSLint.yaml',
			'--fail-on-warnings',
		];

		$process = $this->cmd($command);
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
