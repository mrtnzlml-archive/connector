<?hh

$classLoader = require __DIR__ . '/../vendor/autoload.php';
//\Tracy\Debugger::barDump($classLoader);

$configurator = new Nette\Configurator();

//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
$configurator->enableDebugger(__DIR__ . '/../log');
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->addConfig(__DIR__ . '/config/config.neon');

$container = $configurator->createContainer();

error_reporting(E_ALL & ~E_USER_DEPRECATED); //FIXME

return $container;
