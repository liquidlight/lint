<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class YamlLint extends Base
{
	protected static $defaultName = 'yaml:lint';

	protected function configure(): void
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('YAML Lint')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$command = "find . ! -path '*vendor/*' ! -path '*node_modules/*' ! -path '*html/*' -name '*.yml' -o -name '*.yaml' | xargs -r php " . $this->path . "/vendor/bin/yaml-lint";

		$process = $this->cmdString($command);
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
