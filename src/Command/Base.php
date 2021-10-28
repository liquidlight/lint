<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

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

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->input = $input;
		$this->output = $output;

		$this->io = new SymfonyStyle($input, $output);

		return Command::SUCCESS;
	}

	protected function getTitle()
	{
		$this->io->title(sprintf('%s <fg=white>%s</>', $this->getDescription(), $this->getName()));
	}

	protected function cmd($command)
	{
		$process = new Process($command);
		$process->setTty(Process::isTtySupported());
		$process->run();

		if (!Process::isTtySupported()) {
			echo $process->getOutput();
		}

		return $process;
	}

	protected function outputResult($process)
	{
		if ($process->isSuccessful()) {
			$this->io->success($this->getDescription() . ' passed');
		} else {
			$this->io->warning($this->getDescription() . ' was not successful');
		}
	}

	protected function findFiles($ext, $ignore = [])
	{
		$finder = new Finder();
		$finder->files()
			->in(getcwd())->name('*.' . $ext)
			->notPath(array_filter(array_merge(['vendor/', 'node_modules/'], $ignore)))
			;

		if ($this->output->isVerbose() && !$finder->hasResults()) {
			$this->io->info('No ' . $ext . ' files found');
		}

		return $finder;
	}

	protected function hasFiles($ext, $ignore = []) {
		return $this->findFiles($ext, $ignore)->hasResults();
	}
}
