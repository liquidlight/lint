<?php

// src/Command/CreateUserCommand.php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Seld\JsonLint\JsonParser;
use Exception;

class JsonLint extends Base
{
	protected static $defaultName = 'json:lint';

	protected function configure(): void
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('JsonLint')
			->setAliases(['json:lint'])
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$config = (object)json_decode(
			file_get_contents($this->path . '/resources/config/jsonlint.json') ?: ''
		);

		$files = $this->findFiles($config->extension, $config->ignore);

		if (!$files->hasResults()) {
			return Command::SUCCESS;
		}

		$this->printTitle();

		$response = Command::SUCCESS;
		$parser = new JsonParser();
		foreach ($files as $file) {
			try {
				$content = $file->getContents();
				//var_dump($content);
				$error = $parser->lint($content);
				if ($error) {
					throw $error;
				}
			} catch (Exception $ex) {
				$this->io->warning("JSON parsing error in " . $file->getRelativePathname());
				$this->io->text("\t" . implode("\n\t", array_map('trim', explode("\n", $ex->getMessage()))));
				$response = Command::FAILURE;
			}
		}
		return $response;
	}
}
