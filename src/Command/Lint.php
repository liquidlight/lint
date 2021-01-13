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

class Lint extends Base
{
	// the name of the command (the part after "bin/console")
	protected static $defaultName = 'lint';

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
				InputOption::VALUE_OPTIONAL,
				'Should the linter fix the code?',
				false
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{

		$yaml = getcwd() . '/.gitlab-ci.yml';

		if(!file_exists($yaml)) {
			$output->writeln('There is no gitlab.ci.yml');
			return Command::FAILURE;
		}

		$ci = Yaml::parseFile($yaml);

		if(!isset($ci['stages'])) {
			$output->writeln('Your gitlab-ci.yaml does not define any stages');
			return Command::FAILURE;
		}

		$jobs = [];
		foreach($ci as $title => $item) {
			if(isset($item['stage'])) {
				$jobs[$item['stage']][$title] = $item;
			}
		}

		if(!count($jobs)) {
			$output->writeln('There are no jobs with stages');
			return Command::FAILURE;
		}

		if(isset($ci['before_script'])) {
			$process = new Process($command);
			$process->setTty(true);
			$process->run();
		}

		$fix = false;
		if($input->getOption('fix') !== false) {
			$fix = ' --fix';
		}

		foreach($ci['stages'] as $stage) {
			$output->writeln('Stage: ' . $stage);
			foreach($jobs[$stage] as $title => $job) {

				$output->writeln('Job: ' . $title);
				foreach($job['script'] as $script) {
					if($fix) {
						$script = $script . $fix;
					}

					$output->writeln('script: ' . $script);
					$process = new Process(explode(' ', $script));
					$process->setTty(true);
					$process->run();
					$output->writeln('---');
				}
			}
		}

		return Command::SUCCESS;
	}
}
