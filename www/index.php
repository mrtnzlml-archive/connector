<?php declare(strict_types = 1);

//http://php.net/manual/en/functions.arguments.php#functions.arguments.type-declaration.strict

if (PHP_SAPI === 'cli') {
	die("\e[37;41m To run application in CLI mode use 'bin/console' instead. \e[0m\n");
}

$container = require __DIR__ . '/../bootstrap.php';
$container->getByType(Nette\Application\Application::class)->run();
