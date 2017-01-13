<?php declare(strict_types = 1);

require __DIR__ . '/vendor/autoload.php';

$configurator = new Nette\Configurator;
//$configurator->setDebugMode(FALSE); //API should return only 500 - Internal Server Error
$configurator->defaultExtensions['extensions'] = \Adeira\ConfigurableExtensionsExtension::class;
$logDirectory = __DIR__ . '/log';

if (PHP_SAPI === 'cli') {
	\Symfony\Component\Debug\Debug::enable();
	\Tracy\Debugger::$logDirectory = $logDirectory;
} else {
	//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
	$configurator->enableDebugger($logDirectory);
}

$configurator->setTempDirectory(__DIR__ . '/temp');
$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

\Tracy\Dumper::$objectExporters[\Ramsey\Uuid\Uuid::class] = function (\Ramsey\Uuid\Uuid $uuid) {
	return ['value' => $uuid->toString()];
};

return $configurator->createContainer();
