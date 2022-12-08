<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\PostRector\Rector\NameImportingPostRector;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;

return static function (RectorConfig $rectorConfig): void {
	// If you want to override the number of spaces for your typoscript files you can define it here, the default value is 4
	$rectorConfig->indent("\t", 1);

	// Define your target version which you want to support
	$rectorConfig->phpVersion(PhpVersion::PHP_74);

	// If you use importNames(), you should consider excluding some TYPO3 files.
	$rectorConfig->skip([
		// @see https://github.com/sabbelasichon/typo3-rector/issues/2536
		getcwd() . '/**/Configuration/ExtensionBuilder/*',
		// We skip those directories on purpose as there might be node_modules or similar
		// that include typescript which would result in false positive processing
		getcwd() . '/**/Resources/**/node_modules/*',
		getcwd() . '/**/Resources/**/NodeModules/*',
		getcwd() . '/**/Resources/**/BowerComponents/*',
		getcwd() . '/**/Resources/**/bower_components/*',
		getcwd() . '/**/Resources/**/build/*',
		getcwd() . '/vendor/*',
		getcwd() . '/Build/*',
		getcwd() . '/public/*',
		getcwd() . '/.github/*',
		getcwd() . '/.Build/*',
		NameImportingPostRector::class => [
			'ext_localconf.php',
			'ext_tables.php',
			'ClassAliasMap.php',
			getcwd() . '/**/Configuration/*.php',
			getcwd() . '/**/Configuration/**/*.php',
		],
	]);


	$rectorConfig->rule(\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector::class);
	$rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);
};
