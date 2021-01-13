<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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

		foreach($ci['stages'] as $stage) {
			$output->writeln($stage);
			foreach($jobs[$stage] as $title => $job) {
				$output->writeln($title);
			}
		}
		// this method must return an integer number with the "exit status code"
		// of the command. You can also use these constants to make code more readable

		// return this if there was no problem running the command
		// (it's equivalent to returning int(0))
		return Command::SUCCESS;

		// or return this if some error happened during the execution
		// (it's equivalent to returning int(1))
		//
	}
}
