<?php

// src/Command/CreateUserCommand.php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Seld\JsonLint\JsonParser;
use Exception;

class JsonLint extends Base
{
	protected static $defaultName = 'json:lint';

	protected function configure()
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

		$config = json_decode(file_get_contents($this->path . '/resources/config/jsonlint.json'));
		$files = $this->findFiles($config->extension, $config->ignore);
		if (!$files) {
			return Command::SUCCESS;
		}

		$this->getTitle();

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
