<?php

namespace LintKit\ComposerNormalize\Command;

use LintKit\Linter\Command\Base;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ComposerNormalizeCommand extends Base
{
	protected function configure(): void
	{
		parent::configure();

		$this
			->setName('composer:normalize')
			// the short description shown while running "php bin/console list"
			->setDescription('Composer Normalize')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		parent::execute($input, $output);

		$composer_path = exec('which composer');

		$failures = [];
		$files = [];

		$finder = new Finder();
		$finder->in(__DIR__)->exclude('vendor');

		if (file_exists(getcwd() . '/app')) {
			$finder->files()
				->in(getcwd() . '/app')->name('composer.json')
			;

			$files = array_merge(iterator_to_array($finder), $files);
		}

		if (file_exists(getcwd() . '/src')) {
			$finder->files()
				->in(getcwd() . '/src')->name('composer.json')
			;

			$files = array_merge(iterator_to_array($finder), $files);
		}

		$files[] = getcwd() . '/composer.json';

		foreach ($files as $composerFile) {
			$command = [
				PHP_BINARY,
				$composer_path,
				'--working-dir', $this->path,
				'normalize',
				$composerFile,
				'--indent-size', '4',
				'--indent-style', 'space',
			];

			if ($output->isVerbose()) {
				$command[] = '-v';
			}

			if ($this->input->getOption('fix') === false) {
				$command[] = '--dry-run';
			}

			if ($this->input->getOption('whisper')) {
				$command[] = '--quiet';
			}

			$process = $this->cmd($command);
			$this->io->newLine();
			$this->outputResult($process);

			if (!$process->isSuccessful()) {
				$failures[] = $composerFile;
			}
		}


		return count($failures) ? Command::FAILURE : Command::SUCCESS;
	}
}
