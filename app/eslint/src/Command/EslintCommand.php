<?php

namespace LiquidLight\Eslint\Command;

use LiquidLight\Linter\Command\Base;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EslintCommand extends Base
{
	protected function configure(): void
	{
		parent::configure();

		$this
			->setName('js:eslint')
			// the short description shown while running "php bin/console list"
			->setDescription('ESLint')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		parent::execute($input, $output);
		$extPath = dirname(__DIR__) . '/..';


		$fileCheck = $this->hasFiles('js');
		if (!$fileCheck) {
			return Command::SUCCESS;
		}

		$command = [
			$this->path . '/node_modules/eslint/bin/eslint.js',
			getcwd(),
			'--color',
			'--cache',
			'--ignore-pattern', '*/typo3/sysext/*',
			'--config', $extPath . '/resources/config/eslint.config.mjs',
			'--cache-location', $extPath . '/.cache/',
			'--cache-strategy', 'content',
		];

		if ($this->input->getOption('fix') !== false) {
			$command[] = '--fix';

			$this->io->text('Attempting to fix...');
		}

		$process = $this->cmd($command);
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
