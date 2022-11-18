<?php

// src/Command/CreateUserCommand.php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;

class Run extends Base
{
	// the name of the command (the part after "bin/console")
	protected static $defaultName = 'run';

	// Is the fix flag on it?
	protected bool $fix = false;

	// ...
	protected function configure(): void
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Lints the code')

			// the full command description shown when running the command with
			// the "--help" option
			->setHelp('This command allows you to create a user...')
			->addOption(
				'fix',
				'f',
				InputOption::VALUE_NONE,
				'Should the linter fix the code?'
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->output = $output;
		$this->io = new SymfonyStyle($input, $output);

		if ($input->getOption('fix') !== false) {
			$this->fix = true;
			$this->io->warning('Global `--fix` has been deprecated, please run fix on the individual linter');
			$this->io->note('This will be removed in the next version');
			$result = $this->io->confirm('Continue for now?');

			if (!$result) {
				return Command::FAILURE;
			}
		}

		if (
			file_exists('composer.json') &&
			$composer = json_decode(file_get_contents('composer.json') ?: '', true)
		) {
			if (isset($composer['scripts'], $composer['scripts']['lint'])) {
				$process = $this->cmdString('composer lint');
				return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
			}
		}

		return $this->genericLint();
	}

	protected function genericLint(): int
	{
		$return = [];
		$scripts = [
			'scss:lint',
			'js:lint',
			'php:coding-standards',
		];

		if (!$this->getApplication()) {
			$this->io->error('There is no application');
			return Command::FAILURE;
		}

		foreach ($scripts as $script) {
			$command = $this->getApplication()->find(trim($script));
			$args = [];
			if ($this->fix) {
				$args['--fix'] = true;
			}

			$returnCode = $command->run(new ArrayInput($args), $this->output);

			if ($returnCode > 0) {
				$return[] = $script;
			}
		}

		if (count($return) > 0) {
			$this->io->warning(array_merge(
				[count($return) . ' lint task(s) failed:'],
				$return
			));
			foreach ($return as $index => $job) {
				$return[$index] = sprintf('lint %s --fix', $job);
			}
			$this->io->info(array_merge(
				['This might be able to be resolved with:'],
				$return
			));
		} else {
			$this->io->success('Linting passed');
		}

		if ($this->fix) {
			$this->cmd(['/usr/bin/git', 'status']);
		}

		return count($return) > 0 ? Command::FAILURE : Command::SUCCESS;
	}
}
