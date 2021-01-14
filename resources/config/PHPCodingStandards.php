<?php

// The directory the script is being run from
$dir = $GLOBALS['_SERVER']['PWD'];
$cwd = __DIR__ . '/../../';

$finder = PhpCsFixer\Finder::create()
	// Projects
	->exclude('backup')
	->exclude('html/assets')
	->exclude('html/fileadmin')
	->exclude('html/import')
	->exclude('html/typo3')
	->exclude('html/typo3_src')
	->exclude('html/typo3conf/autoload')
	->exclude('html/typo3conf/l10n')
	->exclude('html/typo3temp')
	->exclude('html/uploads')

	->notPath('html/index.php')
	->notPath('html/typo3conf/LocalConfiguration.php')
	->notPath('html/typo3conf/PackageStates.php')

	// TYPO3
	->exclude('typo3/install')
	->exclude('typo3/sysext')

	->notPath('typo3/install.php')

	// Summit
	->exclude('storage')
	->notPath('*blade.php')

	// General
	->exclude('Library')
	->exclude('vendor')

	->ignoreDotFiles(true)
	->ignoreUnreadableDirs()
	->ignoreVCSIgnored(true)

	->in($dir)
	;

$config = new PhpCsFixer\Config();
return $config->setRules([
		'@PSR2' => true,

		'indentation_type' => false
	])
	->setIndent('	')
	->setCacheFile($cwd . '.cache/.phpcscache_' . md5($dir))
	->setFinder($finder)
	;
