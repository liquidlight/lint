<?php

namespace LiquidLight\ComposerNormalize\Command;

use App\Command\Base;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ComposerNormalizeCommand extends Base
{
	protected static $defaultName = 'composer:normalize';

	protected function configure(): void
	{
		parent::configure();

		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Composer Normalize')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);


		$command = [
			'composer',
			'--working-dir', $this->path,
			'normalize',
			getcwd() . '/composer.json',
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

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
