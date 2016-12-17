<?php declare(strict_types = 1);

require __DIR__ . '/vendor/autoload.php';

$configurator = new Nette\Configurator;
$configurator->defaultExtensions['extensions'] = \Adeira\ConfigurableExtensionsExtension::class;

if (PHP_SAPI === 'cli') {
	$input = new \Symfony\Component\Console\Input\ArgvInput;
	$env = $input->getParameterOption(['--env', '-e'], getenv('NETTE_ENV') ?: 'dev');
	$debug = getenv('NETTE_DEBUG') !== '0' && !$input->hasParameterOption(['--no-debug', '']) && $env !== 'prod';

	if ($debug) {
		\Symfony\Component\Debug\Debug::enable();
		$configurator->setDebugMode(TRUE);
	}
}

//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
$configurator->enableDebugger(__DIR__ . '/log');
$configurator->setTempDirectory(__DIR__ . '/temp');
$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

\Tracy\Dumper::$objectExporters[\Ramsey\Uuid\Uuid::class] = function (\Ramsey\Uuid\Uuid $uuid) {
	return ['value' => $uuid->toString()];
};

return $configurator->createContainer();
