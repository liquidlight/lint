<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\PostRector\Rector\NameImportingPostRector;
use Ssch\TYPO3Rector\Rector\General\ConvertImplicitVariablesToExplicitGlobalsRector;
use Ssch\TYPO3Rector\Rector\General\ExtEmConfRector;
use Ssch\TYPO3Rector\Set\Typo3LevelSetList;

return static function (RectorConfig $rectorConfig): void {
	// If you want to override the number of spaces for your typoscript files you can define it here, the default value is 4
	$rectorConfig->indent("\t", 1);

	$rectorConfig->sets([
		Typo3LevelSetList::UP_TO_TYPO3_12,
	]);

	// Define your target version which you want to support
	$rectorConfig->phpVersion(PhpVersion::PHP_82);

	// If you only want to process one/some TYPO3 extension(s), you can specify its path(s) here.
	// If you use the option --config change getcwd() to getcwd()
	// $rectorConfig->paths([
	//    getcwd() . '/packages/acme_demo/',
	// ]);

	// When you use rector there are rules that require some more actions like creating UpgradeWizards for outdated TCA types.
	// To fully support you we added some warnings. So watch out for them.

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

	// If you have trouble that rector cannot run because some TYPO3 constants are not defined add an additional constants file
	// @see https://github.com/sabbelasichon/typo3-rector/blob/master/typo3.constants.php
	// @see https://github.com/rectorphp/rector/blob/main/docs/static_reflection_and_autoload.md#include-files
	// $parameters->set(Option::BOOTSTRAP_FILES, [
	//    getcwd() . '/typo3.constants.php'
	// ]);

	// register a single rule
	// $rectorConfig->rule(\Ssch\TYPO3Rector\Rector\v9\v0\InjectAnnotationRector::class);

	/**
	 * Useful rule from RectorPHP itself to transform i.e. GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')
	 * to GeneralUtility::makeInstance(\TYPO3\CMS\Core\Log\LogManager::class) calls.
	 * But be warned, sometimes it produces false positives (edge cases), so watch out
	 */
	$rectorConfig->rule(\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector::class);

	// Optional non-php file functionalities:
	// @see https://github.com/sabbelasichon/typo3-rector/blob/main/docs/beyond_php_file_processors.md

	// Rewrite your extbase persistence class mapping from typoscript into php according to official docs.
	// This processor will create a summarized file with all the typoscript rewrites combined into a single file.
	/* $rectorConfig->ruleWithConfiguration(\Ssch\TYPO3Rector\FileProcessor\TypoScript\Rector\v10\v0\ExtbasePersistenceTypoScriptRector::class, [
		\Ssch\TYPO3Rector\FileProcessor\TypoScript\Rector\v10\v0\ExtbasePersistenceTypoScriptRector::FILENAME => getcwd() . '/packages/acme_demo/Configuration/Extbase/Persistence/Classes.php',
	]); */
	// Add some general TYPO3 rules
	$rectorConfig->rule(ConvertImplicitVariablesToExplicitGlobalsRector::class);
	$rectorConfig->ruleWithConfiguration(ExtEmConfRector::class, [
		ExtEmConfRector::ADDITIONAL_VALUES_TO_BE_REMOVED => [],
	]);

	// Modernize your TypoScript include statements for files and move from <INCLUDE /> to @import use the FileIncludeToImportStatementVisitor (introduced with TYPO3 9.0)
	// $rectorConfig->rule(\Ssch\TYPO3Rector\FileProcessor\TypoScript\Rector\v9\v0\FileIncludeToImportStatementTypoScriptRector::class);
};
