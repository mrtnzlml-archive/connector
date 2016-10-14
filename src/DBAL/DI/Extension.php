<?php declare(strict_types = 1);

namespace Adeira\Connector\DBAL\DI;

class Extension extends \Nette\DI\CompilerExtension
{

	private $defaults = [
		'dbname' => NULL,
		'user' => NULL,
		'password' => NULL,
		'host' => '127.0.0.1',
		'driver' => 'pdo_pgsql',
	];

	public function loadConfiguration()
	{
		$config = $this->validateConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$builder
			->addDefinition($this->prefix('connection'))
			->setClass(\Doctrine\DBAL\Driver\Connection::class)
			->setFactory('Doctrine\DBAL\DriverManager::getConnection', [
				$config,
				new \Doctrine\DBAL\Configuration,
			]);
	}

}
