<?php declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

$rootTestPaths = [
	__DIR__ . '/extensions',
	__DIR__ . '/src',
];

foreach ($rootTestPaths as $rootPath) {
	$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath));
	foreach ($iterator as $fileInfo) {
		$path = str_replace(__DIR__, '', $fileInfo->getPath());
		if (preg_match('~(/output$)~', $path)) { // ignore paths
			continue;
		}

		$filename = $fileInfo->getFilename();
		if (!preg_match('~(\.phpt$)~', $filename)) { // allow extensions
			continue;
		}

		Tester\Assert::true(file_exists(__DIR__ . '/..' . $path), 'TESTS PATH MISHMASH ' . $path);
	}
}
