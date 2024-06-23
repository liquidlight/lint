<?php

namespace LintKit\JsonLint\Command;

use LintKit\Base\Command\Base;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Seld\JsonLint\JsonParser;
use Exception;

class JsonLintCommand extends Base
{
	protected function configure(): void
	{
		$this
			->setName('json:lint')
		// the short description shown while running "php bin/console list"
			->setDescription('JSON linting')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		parent::execute($input, $output);
		$extPath = dirname(__DIR__) . '/..';

		$config = (object)json_decode(
			file_get_contents($extPath . '/resources/config/jsonlint.json') ?: ''
		);

		$files = $this->findFiles($config->extension, $config->ignore);

		if (!$files->hasResults()) {
			return Command::SUCCESS;
		}

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
