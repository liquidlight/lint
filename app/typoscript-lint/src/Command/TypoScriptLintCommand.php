<?php

namespace LiquidLight\TypoScriptLint\Command;

use LiquidLight\Linter\Command\Base;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TypoScriptLintCommand extends Base
{
	protected static $defaultName = 'typoscript:lint';

	protected function configure(): void
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Typoscript Lint')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);
		$extPath = dirname(__DIR__) . '/..';

		$command = [
			$this->path . '/vendor/bin/typoscript-lint',
			'--config=' . $extPath . '/resources/config/TSLint.yaml',
			'--fail-on-warnings',
		];

		$process = $this->cmd($command);
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
