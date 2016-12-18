<?php declare(strict_types = 1);

namespace Adeira\Connector\Doctrine\ORM\DI;

use Nette\DI;

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
			'cacheDriver' => NULL,
			'cacheDriverConfig' => ['%tempDir%/cache/Doctrine.Cache'],
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
			$mappingFilePaths = array_merge($mappingFilePaths, $extension->getMappingFilesPaths());
		}

		$configurationConfig = $config['configuration'];

		// Cache Driver
		if ($configurationConfig['cacheDriver'] === NULL) {
			$configurationConfig['cacheDriver'] = (new DI\Statement(\Doctrine\Common\Cache\FilesystemCache::class))->getEntity();
		}
		$cacheDriver = $builder->addDefinition($this->prefix('cacheDriver'))->setClass(
			$configurationConfig['cacheDriver'],
			$configurationConfig['cacheDriverConfig']
		);

		// Configuration
		$configuration = $builder
			->addDefinition($this->prefix('configuration'))
			->setClass(\Doctrine\ORM\Configuration::class)
			->setFactory('Doctrine\ORM\Tools\Setup::createXMLMetadataConfiguration', [
				$configurationConfig['mappingFilesPaths'] + $mappingFilePaths,
				$configurationConfig['isDevMode'],
				$configurationConfig['proxyDir'],
				$cacheDriver,
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
