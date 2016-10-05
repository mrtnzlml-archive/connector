<?php declare(strict_types = 1);

namespace App\PostgreJSON\DI;

class Extension extends \Nette\DI\CompilerExtension
{

	private $defaults = [
		'username' => NULL,
		'password' => NULL,
		'database' => NULL,
	];

	public function loadConfiguration()
	{
		$config = $this->validateConfig($this->defaults);

		$builder = $this->getContainerBuilder();
		$builder
			->addDefinition($this->prefix('connection'))
			->setClass(\App\PostgreJSON\Connection::class, [
				$config['username'],
				$config['password'],
				$config['database'],
			])->setAutowired(FALSE);

		$builder
			->addDefinition($this->prefix('dml.select'))
			->setClass(\App\PostgreJSON\DML\Select::class, [
				$builder->getDefinition($this->prefix('connection')),
			]);
	}

}
