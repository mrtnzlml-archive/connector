<?php declare(strict_types = 1);

//http://php.net/manual/en/functions.arguments.php#functions.arguments.type-declaration.strict

$container = require __DIR__ . '/../app/bootstrap.php';
$container->getByType(Nette\Application\Application::class)->run();
