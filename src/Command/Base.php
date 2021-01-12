<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;

class Base extends Command {
	protected $path;

	public function __construct($dir) {
		parent::__construct();
		$this->path = $dir;
	}
}
