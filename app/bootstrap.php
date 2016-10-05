<?php declare(strict_types = 1);

$classLoader = require __DIR__ . '/../vendor/autoload.php';
//\Tracy\Debugger::barDump($classLoader);

$configurator = new Nette\Configurator();

//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
$configurator->enableDebugger(__DIR__ . '/../log');
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->addConfig(__DIR__ . '/config/config.neon');

$localConfig = __DIR__ . '/config/config.local.neon';
if (file_exists($localConfig)) {
	$configurator->addConfig($localConfig);
}

$container = $configurator->createContainer();

return $container;
