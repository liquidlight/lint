<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;

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

		$yaml = getcwd() . '/.gitlab-ci.yml';
		$nodemodules = is_link('node_modules');

		$return = [];

		if (!file_exists($yaml)) {
			$output->writeln('There is no gitlab.ci.yml');
			return Command::FAILURE;
		}

		$ci = Yaml::parseFile($yaml);

		if (!isset($ci['stages'])) {
			$output->writeln('Your gitlab-ci.yaml does not define any stages');
			return Command::FAILURE;
		}

		$jobs = [];
		foreach ($ci as $title => $item) {
			if (isset($item['stage'])) {
				$jobs[$item['stage']][$title] = $item;
			}
		}

		if (!count($jobs)) {
			$output->writeln('There are no jobs with stages');
			return Command::FAILURE;
		}

		if (isset($ci['before_script'])) {
			if ($nodemodules) {
				$output->writeln('Stage: before_script | script: creating CI symlink');
				symlink('/usr/local/share/ci', 'ci');
			} else {
				$output->writeln('Stage: before_script | ');
				foreach ($ci['before_script'] as $script) {
					$returnCode = $this->run_script($script);
					if($returnCode > 0) {
						$return[] = $script;
					}
					$output->writeln('---');
				}
			}
		}

		if ($input->getOption('fix') !== false) {
			$this->fix = true;
		}

		foreach ($ci['stages'] as $stage) {
			$output->write('Stage: ' . $stage . ' | ');

			foreach ($jobs[$stage] as $title => $job) {
				$output->write('Job: ' . $title . ' | ');
				foreach ($job['script'] as $script) {
					$returnCode = $this->run_script($script);
					if($returnCode > 0) {
						$return[] = $script;
					}
					$output->writeln('---');
				}
			}
		}

		// clean up the old CI
		if (is_link(getcwd() . '/ci')) {
			$output->writeln('Stage: after_script | script: removing CI symlink');
			$cmd = ['rm', getcwd() . '/ci'];
			if (!$nodemodules) {
				$cmd[] = 'node_modules';
			}

			$process = new Process($cmd);
			$process->run();
			$output->writeln('---');
		}

		if(count($return) > 0) {
			$io->warning(array_merge(
				[count($return) . ' lint task(s) failed:'],
				$return
			));
		} else {
			$io->success('Linting passed');
		}
		
		return count($return) > 0 ? Command::FAILURE : Command::SUCCESS;
	}

	private function run_script($script)
	{
		$scripts = explode('&&', $script);
		foreach ($scripts as $script) {
			$script = trim($script);
			$this->output->writeln('script: ' . $script);
			if(substr($script, 0, 4) === 'lint') {
				$script = str_replace('lint', '', $script);
				$command = $this->getApplication()->find(trim($script));
				$args = [];
				if($this->fix) {
					$args['--fix'] = true;
				}

				$returnCode = $command->run(new ArrayInput($args), new \Symfony\Component\Console\Output\NullOutput);
			} else {
				// This is the old CI
				if ($this->fix) {
					$script = $script . ($this->fix ? ' --fix' : '');
				}
				$process = $this->cmd(explode(' ', $script));
				$returnCode = $process->getExitCode();
			}
		}

		return $returnCode;
	}
}
