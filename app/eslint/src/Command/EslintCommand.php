<?php

namespace LiquidLight\Eslint\Command;

use App\Command\Base;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EslintCommand extends Base
{
	protected static $defaultName = 'js:eslint';

	protected function configure(): void
	{
		parent::configure();

		$this
			// the short description shown while running "php bin/console list"
			->setDescription('ESLint')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);
		$extPath = dirname(__DIR__) . '/..';

		$ignore = explode(
			PHP_EOL,
			file_get_contents($extPath . '/resources/config/Eslint-Ignore') ?: ''
		);
		$fileCheck = $this->hasFiles('js', $ignore);
		if (!$fileCheck) {
			return Command::SUCCESS;
		}

		// Also in Dockerfiles/JsEslint.dockerfile
		$command = [
			$this->path . '/node_modules/.bin/eslint',
			getcwd(),
			'--color',
			'--cache',
			'--ext', '.js',
			'--config', $extPath . '/resources/config/Eslint.js',
			'--ignore-path', $extPath . '/resources/config/Eslint-Ignore',
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
