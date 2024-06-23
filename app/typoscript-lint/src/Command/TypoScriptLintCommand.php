<?php

namespace LintKit\TypoScriptLint\Command;

use LintKit\Base\Command\Base;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TypoScriptLintCommand extends Base
{
	protected function configure(): void
	{
		$this
			->setName('typoscript:lint')
			// the short description shown while running "php bin/console list"
			->setDescription('Typoscript Lint')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		parent::execute($input, $output);
		$extPath = dirname(__DIR__) . '/..';

		$command = [
			PHP_BINARY,
			$this->path . '/vendor/bin/typoscript-lint',
			'--config=' . $extPath . '/resources/config/TSLint.yaml',
			'--fail-on-warnings',
		];

		$process = $this->cmd($command);
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
