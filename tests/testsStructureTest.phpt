<?php declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

$rootTestPaths = [
	__DIR__ . '/extensions',
	__DIR__ . '/src',
];

$ignoreList = [
	'/output$',
];

$ignoreList = implode('|', $ignoreList);
foreach ($rootTestPaths as $rootPath) {
	$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath));
	foreach ($iterator as $fileInfo) {
		if ($fileInfo->getFilename() === '.') {
			$path = str_replace(__DIR__, '', $fileInfo->getPath());
			if (preg_match("~$ignoreList~", $path)) {
				continue;
			}
			Tester\Assert::true(is_dir(__DIR__ . '/../' . $path), 'TESTS PATH MISHMASH ' . $path);
		}
	}
}
