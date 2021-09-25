<?php

// src/Command/CreateUserCommand.php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\NullOutput;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Symfony\Component\Yaml\Yaml;

class Run extends Base
{
	// the name of the command (the part after "bin/console")
	protected static $defaultName = 'run';

	// Is the fix flag on it?
	protected $fix = false;

	// ...
	protected function configure()
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Lints the code')

			// the full command description shown when running the command with
			// the "--help" option
			->setHelp('This command allows you to create a user...')
			->addOption(
				'fix',
				true,
				InputOption::VALUE_NONE,
				'Should the linter fix the code?'
			)
			;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->output = $output;
		$io = new SymfonyStyle($input, $output);

		if ($input->getOption('fix') !== false) {
			$this->fix = true;
		}

		$return = [];
		$scripts = [
			'scss:lint',
			'js:lint',
			'php:coding-standards',
		];

		foreach($scripts as $script) {
			$io->section('Running: ' . $script);

			$command = $this->getApplication()->find(trim($script));
			$args = [];
			if ($this->fix) {
				$args['--fix'] = true;
			}

			$returnCode = $command->run(new ArrayInput($args), new NullOutput());

			if ($returnCode > 0) {
				$return[] = $script;
			}
		}

		$output->writeln('');

		if (count($return) > 0) {
			$io->warning(array_merge(
				[count($return) . ' lint task(s) failed:'],
				$return
			));
			$io->info(['This can be resolved with', 'lint run --fix']);
		} else {
			$io->success('Linting passed');
		}

		if ($this->fix) {
			$this->cmd(['/usr/bin/git', 'status']);
		}

		return count($return) > 0 ? Command::FAILURE : Command::SUCCESS;
	}

}
