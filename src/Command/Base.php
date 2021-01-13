<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;

class Base extends Command {
	protected $path;

	public function __construct($dir) {
		parent::__construct();
		$this->path = $dir;
		ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	}
}
