<?php

namespace LintKit\Stylelint\Command;

use LintKit\Base\Command\Base;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StylelintCommand extends Base
{
	protected function configure(): void
	{
		parent::configure();

		$this
			->setName('scss:stylelint')
			// the short description shown while running "php bin/console list"
			->setDescription('Stylelint')
			->setAliases(['scss:lint', 'css:lint'])
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		parent::execute($input, $output);
		$extPath = dirname(__DIR__) . '/..';

		$fileCheck = $this->hasFiles('scss');
		if (!$fileCheck) {
			return Command::SUCCESS;
		}

		$command = [
			$this->path . '/node_modules/.bin/stylelint',
			'**/*.scss',
			'--color',
			'--cache',
			'--config', $extPath . '/resources/config/Stylelint.json',
			'--config-basedir', $this->path . '/node_modules/',
			'--ignore-path', $extPath . '/resources/config/Stylelint-Ignore',
			'--cache-location', $extPath . '/.cache/',
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
