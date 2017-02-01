<?php declare(strict_types = 1);

require __DIR__ . '/vendor/autoload.php';

$configurator = new Nette\Configurator;
$configurator->defaultExtensions['extensions'] = [\Adeira\ConfigurableExtensionsExtension::class, [TRUE]];
$logDirectory = __DIR__ . '/var/log';

if (PHP_SAPI === 'cli' && getenv('NETTE_DEBUG') === '1') {
	$configurator->setDebugMode(TRUE);
	\Symfony\Component\Debug\Debug::enable();
	\Tracy\Debugger::$logDirectory = $logDirectory;
} else {
	//$configurator->setDebugMode(FALSE); //API should return only 500 - Internal Server Error
	$configurator->enableDebugger($logDirectory);
}

$configurator->setTempDirectory(__DIR__ . '/var/temp');
$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

\Tracy\Dumper::$objectExporters[\Ramsey\Uuid\Uuid::class] = function (\Ramsey\Uuid\Uuid $uuid) {
	return ['value' => $uuid->toString()];
};

return $configurator->createContainer();
