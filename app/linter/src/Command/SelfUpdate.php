<?php

// src/Command/CreateUserCommand.php

namespace LintKit\Linter\Command;

use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SelfUpdate extends Base
{
	protected function configure(): void
	{
		$this
			->setName('self-update')
		// the short description shown while running "php bin/console list"
			->setDescription('Updates the linter')
			->addOption(
				'dev',
				null,
				InputOption::VALUE_OPTIONAL,
				'Go onto the main branch',
				false,
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		parent::execute($input, $output);

		$command = 'cd ' . $this->path . ' && git fetch origin && git tag --sort=committerdate | tail -1';

		/**
		 * @var \Symfony\Component\Console\Helper\ProcessHelper
		 */
		$helper = $this->getHelper('process');


		$process = Process::fromShellCommandline($command);
		$process->setTimeout(600);
		$helper->run($this->output, $process);

		$tag = trim($process->getOutput());

		if ($this->input->getOption('dev') || is_null($this->input->getOption('dev'))) {
			$branch = trim($this->input->getOption('dev') ?? 'main');

			$this->io->text('Switching to the ' . $this->input->getOption('dev') . ' branch (dev)');
			$command = 'cd ' . $this->path . ' && git checkout ' . $branch . ' && git pull origin ' . $branch;
			$this->cmdString($command);
		} else {
			$this->cmdString('cd ' . $this->path . ' && git checkout ' . $tag);
		}


		$command = 'cd ' . $this->path . ' && composer install && npm ci';
		$this->cmdString($command);

		$command = 'cd ' . $this->path . ' && rm -rf .cache/.* && rm -rf app/*/.cache/.*;';
		$this->cmdString($command);

		$this->io->text('<fg=green>Linter is now on: ' . $tag . '</>');

		return Command::SUCCESS;
	}
}
