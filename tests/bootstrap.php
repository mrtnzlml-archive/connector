<?php declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

Testbench\Bootstrap::setup(__DIR__ . '/_temp', function (\Nette\Configurator $configurator) {
	$configurator->addConfig(__DIR__ . '/../config/config.neon');
	$configurator->addConfig(__DIR__ . '/../config/config.local.neon');
});
