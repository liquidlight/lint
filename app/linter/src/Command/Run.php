<?php

// src/Command/CreateUserCommand.php

namespace LiquidLight\Linter\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Symfony\Component\Console\Input\ArrayInput;

class Run extends Base
{
	// the name of the command (the part after "bin/console")
	protected static $defaultName = 'run';

	// Is the fix flag on it?
	protected bool $fix = false;

	// ...
	protected function configure(): void
	{
		parent::configure();

		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Lints the code')
			->setHelp('This command allows you to create a user...')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->io = new SymfonyStyle($input, $output);

		if ($input->getOption('run') === true) {
			$this->io->info('The --run argument not supported, assuming you meant --fix');
			$input->setOption('fix', true);
		}

		$return = [];

		// Base scripts
		$scripts = [
			'lint scss:stylelint',
			'lint js:eslint',
			'lint php:coding-standards',
		];

		// Override scripts if specified in composer
		if (
			file_exists('composer.json') &&
			$composer = json_decode(file_get_contents('composer.json') ?: '', true)
		) {
			if (isset($composer['scripts'], $composer['scripts']['lint'])) {
				$scripts = $composer['scripts']['lint'];
			}
		}

		if (!$this->getApplication()) {
			$this->io->error('There is no application');
			return Command::FAILURE;
		}

		foreach ($scripts as $script) {
			// Does the command start with "lint"?
			if (substr($script, 0, 4) === 'lint') {
				// Remove the word lint from the start
				$script = trim(substr_replace($script, '', 0, 4));

				// Get any arguments are the end & redclare the script
				$arguments = explode(' ', $script);
				$script_name = array_shift($arguments);

				// Initialise the script
				$command = $this->getApplication()->find(trim($script_name));

				// Turn any arguments into real arguments
				$args = [];
				if (count($arguments)) {
					foreach ($arguments as $argument) {
						$argument = explode('=', $argument);
						$args[trim($argument[0])] = trim($argument[1]) ?: true;
					}
				}

				// Add fix if it has been added
				if ($input->getOption('fix') !== false) {
					$args['--fix'] = true;
				}

				if (!$output->isVerbose() && $input->getOption('fix') === false) {
					$args['--whisper'] = true;
				}

				// Run the command
				$returnCode = $command->run(new ArrayInput($args), $output);
			} else {
				// Otherwise, run it as it is
				$process = $this->cmdString($script);
				$returnCode = $process->getExitCode();
			}

			if ($returnCode > 0) {
				$return[] = $script;
			}
		}

		if (count($return) > 0) {
			$this->io->warning(count($return) . ' lint task(s) failed:' . implode(', ', $return));

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
