<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

use Symfony\Component\Process\Process;

class Base extends Command
{
	protected string $path;

	protected InputInterface $input;

	protected OutputInterface $output;

	protected SymfonyStyle $io;

	public function __construct(string $dir)
	{
		parent::__construct();
		$this->path = $dir;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->input = $input;
		$this->output = $output;

		$this->io = new SymfonyStyle($input, $output);

		$this->printTitle();

		return Command::SUCCESS;
	}

	protected function printTitle(): void
	{
		$this->io->text(sprintf('%s - <fg=green>%s</>', $this->getApplication()->getName(), $this->getApplication()->getVersion()));
		$this->io->title(sprintf('%s <fg=white>%s</>', $this->getDescription(), $this->getName()));
	}

	/**
	 * @param array<int, mixed|false> $command
	 */
	protected function cmd(array $command): Process
	{
		return $this->runCmd(new Process($command));
	}

	/**
	 * @param string $command
	 */
	protected function cmdString(string $command = ''): Process
	{
		return $this->runCmd(Process::fromShellCommandline($command));
	}

	/**
	 * @param Process $process
	 */
	protected function runCmd(Process $process): Process
	{
		$helper = $this->getHelper('process');

		$process->setTty(Process::isTtySupported());
		$process->setTimeout(600);
		$helper->run($this->output, $process);

		if (!Process::isTtySupported()) {
			echo $process->getOutput();
		}

		return $process;
	}

	protected function outputResult(Process $process): void
	{
		if ($process->isSuccessful()) {
			$this->io->text('<fg=green>✓ ' . $this->getDescription() . ' passed</>');
			$this->io->newLine();
		} else {
			$this->io->warning($this->getDescription() . ' was not successful');
		}
	}

	/**
	 * @param array<string> $ignore
	 */
	protected function findFiles(string $ext, array $ignore = []): Finder
	{
		$finder = new Finder();
		$finder->files()
			->in(getcwd() ?: '')->name('*.' . $ext)
			->notPath(array_filter(array_merge(['vendor/', 'node_modules/'], $ignore)))
		;

		if ($this->output->isVerbose() && !$finder->hasResults()) {
			$this->io->info('No ' . $ext . ' files found');
		}

		return $finder;
	}

	/**
	 * @param array<string> $ignore
	 */
	protected function hasFiles(string $ext, array $ignore = []): bool
	{
		return $this->findFiles($ext, $ignore)->hasResults();
	}
}
