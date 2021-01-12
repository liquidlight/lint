<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Lint extends Command
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
		if(!file_exists('.gitlab.ci.yaml')) {
			$output->writeln('There is no gitlab.ci.yaml');
			return Command::FAILURE;
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
