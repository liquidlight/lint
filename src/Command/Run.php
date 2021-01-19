<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Symfony\Component\Yaml\Yaml;

class Run extends Base
{
	// the name of the command (the part after "bin/console")
	protected static $defaultName = 'run';

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
		$yaml = getcwd() . '/.gitlab-ci.yml';
		$nodemodules = is_link('node_modules');

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
					$this->run_script($script);
					$output->writeln('---');
				}
			}
		}

		$fix = false;
		if ($input->getOption('fix') !== false) {
			$fix = ' --fix';
		}

		foreach ($ci['stages'] as $stage) {
			$output->write('Stage: ' . $stage . ' | ');
			foreach ($jobs[$stage] as $title => $job) {
				$output->write('Job: ' . $title . ' | ');
				foreach ($job['script'] as $script) {
					if ($fix) {
						$script = $script . $fix;
					}

					$this->run_script($script);
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

		return Command::SUCCESS;
	}

	private function run_script($script)
	{
		$scripts = explode('&&', $script);
		foreach ($scripts as $script) {
			$script = trim($script);
			$this->output->writeln('script: ' . $script);
			$process = $this->cmd(explode(' ', $script));
		}
	}
}
