<?php

namespace LiquidLight\YamlLint\Command;

use LiquidLight\Linter\Command\Base;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class YamlLintCommand extends Base
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

		$command = "find . -type f \( -iname '*.yaml' -o -iname '*.yml' \) ! -path './vendor/*' ! -path './html/*' ! -path './node_modules/*' | xargs -r php " . $this->path . "/vendor/bin/yaml-lint";

		$process = $this->cmdString($command);
		$this->outputResult($process);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
	}
}
