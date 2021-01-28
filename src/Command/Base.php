<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Base extends Command
{
	protected $path;

	public function __construct($dir)
	{
		parent::__construct();
		$this->path = $dir;
	}

	protected function cmd($command)
	{
		$process = new Process($command);
		$process->setTty(Process::isTtySupported());
		$process->run();

		return $process;
	}

	protected function outputResult($input, $output, $process)
	{
		$io = new SymfonyStyle($input, $output);

		if(!$process->isSuccessful()) {
			$io->warning($this->getDescription() . ' was not successful');
		} else {
			$io->success($this->getDescription() . ' passed');
		}
	}
}
