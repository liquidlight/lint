<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;

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

	protected function run($command) 
	{
		$process = new Process($command);
		$process->setTty(Process::isTtySupported();
		$process->run();

		return $process;
	}
}
