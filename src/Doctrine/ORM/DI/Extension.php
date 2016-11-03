<?php declare(strict_types = 1);

namespace Adeira\Connector\Doctrine\ORM\DI;

class Extension extends \Nette\DI\CompilerExtension
{

	private $defaults = [
		'connection' => [
			'dbname' => NULL,
			'user' => NULL,
			'password' => NULL,
			'host' => '127.0.0.1',
			'driver' => 'pdo_pgsql',
			'types' => [],
		],
		'configuration' => [
			'mappingFilesPaths' => [],
			'isDevMode' => '%debugMode%',
			'proxyDir' => '%tempDir%/cache/Doctrine.Proxy',
		],
		'debugPanel' => TRUE,
	];

	/**
	 * @var bool
	 */
	private $debugMode;

	public function __construct($debugMode = FALSE)
	{
		$this->debugMode = $debugMode;
	}

	public function loadConfiguration()
	{
		$config = $this->validateConfig($this->defaults);
		$builder = $this->getContainerBuilder();
		$config = \Nette\DI\Helpers::expand($config, $builder->parameters, TRUE);

		$mappingFilePaths = [];
		/** @var IMappingFilesPathsProvider $extension */
		foreach ($this->compiler->getExtensions(IMappingFilesPathsProvider::class) as $extension) {
			$mappingFilePaths = $extension->getMappingFilesPaths();
		}

		// Configuration
		$configurationConfig = $config['configuration'];
		$configuration = $builder
			->addDefinition($this->prefix('configuration'))
			->setClass(\Doctrine\ORM\Configuration::class)
			->setFactory('Doctrine\ORM\Tools\Setup::createXMLMetadataConfiguration', [
				$configurationConfig['mappingFilesPaths'] + $mappingFilePaths,
				$configurationConfig['isDevMode'],
				$configurationConfig['proxyDir'],
				NULL, // \Doctrine\Common\Cache\Cache
			]);

		// Connection
		$connection = $builder
			->addDefinition($this->prefix('connection'))
			->setClass(\Doctrine\DBAL\Connection::class)
			->setFactory('Doctrine\DBAL\DriverManager::getConnection', [
				$config['connection'],
				$configuration,
			]);
		$connection->addSetup('$databasePlatform = ?->getDatabasePlatform()', ['@self']);
		foreach ($config['connection']['types'] as $typeName => $typeClass) {
			$connection->addSetup('\Doctrine\DBAL\Types\Type::addType(?, ?)', [
				$typeName,
				$typeClass,
			]);
			$connection->addSetup('$databasePlatform->registerDoctrineTypeMapping(?, ?)', [
				$typeName,
				$typeName,
			]);
		}

		// EntityManager
		$builder
			->addDefinition($this->prefix('entityManager'))
			->setClass(\Doctrine\ORM\EntityManager::class)
			->setFactory('Doctrine\ORM\EntityManager::create', [
				$connection,
				$configuration,
			]);

		// Debug Panel
		if ($this->debugMode && $config['debugPanel']) {
			$connection->addSetup('@Tracy\Bar::addPanel', [
				new \Nette\DI\Statement(\Adeira\Connector\Doctrine\ORM\DI\ConnectionPanel::class),
			]);
		}
	}

}
