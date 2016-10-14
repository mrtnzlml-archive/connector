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
			'mappingClassesPaths' => ['%appDir%'],
			'isDevMode' => '%debugMode%',
			'proxyDir' => '%tempDir%/cache/Doctrine.Proxy',
			'useSimpleAnnotationReader' => FALSE,
		],
	];

	public function loadConfiguration()
	{
		$config = $this->validateConfig($this->defaults);
		$builder = $this->getContainerBuilder();
		$config = \Nette\DI\Helpers::expand($config, $builder->parameters, TRUE);

		// Configuration
		$configurationConfig = $config['configuration'];
		$configuration = $builder
			->addDefinition($this->prefix('configuration'))
			->setClass(\Doctrine\ORM\Configuration::class)
			->setFactory('Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration', [
				$configurationConfig['mappingClassesPaths'],
				$configurationConfig['isDevMode'],
				$configurationConfig['proxyDir'],
				NULL, // \Doctrine\Common\Cache\Cache
				$configurationConfig['useSimpleAnnotationReader'],
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
	}

}
