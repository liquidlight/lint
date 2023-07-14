<?php

namespace LiquidLight\EditorConfig\Command;

use App\Command\Base;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EditorconfigLintCommand extends Base
{
	protected static $defaultName = 'editorconfig:lint';

	protected function configure(): void
	{
		parent::configure();

		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Enforce .editorconfig rules')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);


		$command = [
			$this->path . '/vendor/bin/ec',
		];

		if ($this->input->getOption('whisper')) {
			$command[] = '--quiet';
		}
		if ($output->isDebug()) {
			$command[] = '-vvv';
		} elseif ($output->isVeryVerbose()) {
			$command[] = '-vv';
		} elseif ($output->isVerbose()) {
			$command[] = '-v';
		}

		if ($this->input->getOption('fix')) {
			$this->io->text('Attempting to fix...');
			$command[] = '--fix';
		}


		$process = $this->cmd($command);
		$this->io->newLine();
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
