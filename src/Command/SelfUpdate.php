<?php

// src/Command/CreateUserCommand.php

namespace App\Command;

use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SelfUpdate extends Base
{
	protected static $defaultName = 'self-update';

	protected function configure(): void
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Updates the linter')
			->addOption(
				'dev',
				null,
				InputOption::VALUE_OPTIONAL,
				'Go onto the main branch',
				'main',
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$command = 'cd ' . $this->path . ' && git fetch origin && git tag --sort=committerdate | tail -1';

		$process = Process::fromShellCommandline($command);
		$helper = $this->getHelper('process');
		$process->setTimeout(600);
		$helper->run($this->output, $process);

		$tag = trim($process->getOutput());

		if ($input->getOption('dev') !== false) {
			$tag = trim($input->getOption('dev'));

			$this->io->text('Switching to the ' . $input->getOption('dev') . ' branch (dev)');
		}

		$command = 'cd ' . $this->path . ' && git checkout ' . $tag;
		$this->cmdString($command);

		$command = 'cd ' . $this->path . ' && composer install && npm ci';
		$this->cmdString($command);

		return Command::SUCCESS;
	}
}
