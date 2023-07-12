<?php

namespace LiquidLight\Rector\Command;

use App\Command\Base;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RectorCommand extends Base
{
	protected function configure(): void
	{
		parent::configure();

		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Check your PHP code')
			->addArgument(
				'paths',
				InputArgument::IS_ARRAY,
				'What paths would you like to check',
				['./app']
			)
			->addOption(
				'php-version',
				'p',
				InputOption::VALUE_OPTIONAL,
				'What PHP versions would you check against?',
				'7.4',
			)
		;
	}

	/**
	 * Run rector as a command
	 * @param string $type
	 * @return int
	 */
	protected function runRector(string $type = ''): int
	{
		// Get the paths
		$paths = (array)$this->input->getArgument('paths');

		// Get the PHP version (as passed in e.g. 7.4 and remove the dot 74)
		$phpVersion = (string)$this->input->getOption('php-version');
		$phpVersionSlug = str_pad(str_replace('.', '', $phpVersion), 2, '0');

		// Work out our config path
		$config = $type . '-' . $phpVersionSlug;

		// Check config exists
		if (!is_file($this->getConfigPath($config))) {
			$this->io->error('There is no configuration file for ' . $config);
			return Command::FAILURE;
		}

		$this->io->info(sprintf(
			'Testing against: %s (PHP: %s) in %s',
			implode(' ', explode('-', $type)),
			$phpVersion,
			implode(', ', $paths)
		));

		// Check we have PHP files
		$fileCheck = $this->hasFiles('php');
		if (!$fileCheck) {
			return Command::SUCCESS;
		}

		$command = [
			$this->path . '/vendor/bin/rector',
			'process',
			'--config',
			$this->getConfigPath($config),
			...$paths,
		];

		if ($this->input->getOption('fix') === false) {
			$command[] = '--dry-run';
		} else {
			$this->io->text('Attempting to fix...');
		}

		if ($this->output->isVeryVerbose()) {
			$command[] = '--debug';
		}

		if ($this->input->getOption('whisper')) {
			$command[] = '--no-diffs';
		}

		$process = $this->cmd($command);
		$this->io->newLine();
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}

	/**
	 * Get a rector config file
	 * @param string $name
	 * @return string
	 */
	protected function getConfigPath(string $name)
	{
		$extPath = dirname(__DIR__) . '/..';
		return $extPath . '/resources/config/Rector-' . $name . '.php';
	}
}
