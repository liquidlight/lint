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
	->exclude('var')

	->ignoreDotFiles(true)
	->ignoreUnreadableDirs()

	->in($dir)
;

if (is_dir($dir . '/app')) {
	$finder = $finder->exclude('html/typo3conf/ext');
}

if (is_file($dir . '/.gitignore')) {
	$finder = $finder->ignoreVCSIgnored(true);
}

$config = new PhpCsFixer\Config();
return $config->setRules([
		'@PSR12' => true,

		'indentation_type' => true,

		'array_syntax' => ['syntax' => 'short'],
		'concat_space' => ['spacing' => 'one'],
		'no_empty_statement' => false,
		'no_whitespace_in_blank_line' => true,

		'blank_line_after_opening_tag' => true,
		'cast_spaces' => ['space' => 'none'],
		'class_attributes_separation' => [
			'elements' => [
				'method' => 'one',
				'property' => 'one',
				'const' => 'one',
			],
		],
		'type_declaration_spaces' => true,
		'include' => true,
		'lowercase_cast' => true,
		'lowercase_static_reference' => true,
		'magic_constant_casing' => true,
		'native_function_casing' => true,
		'no_alternative_syntax' => true,
		'ternary_operator_spaces' => true,
		'unary_operator_spaces' => true,

		'multiline_whitespace_before_semicolons' => [
			'strategy' => 'new_line_for_chained_calls',
		],
		'trailing_comma_in_multiline' => true,
		'no_multiline_whitespace_around_double_arrow' => true,
	])
	->setIndent("\t")
	->setCacheFile($cwd . '.cache/.phpcscache_' . md5($dir))
	->setFinder($finder)
;
