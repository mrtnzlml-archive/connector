<?php declare(strict_types = 1);

namespace Adeira\Connector\ServiceBus\Infrastructure\DI\Nette;

use Adeira\Connector\ServiceBus\Infrastructure\DomainModel\TransactionalCommandBus;

final class Extension extends \Nette\DI\CompilerExtension
{

	public $defaults = [
		'commandBus' => TransactionalCommandBus::class,
		'dispatchMap' => [],
	];

	public function loadConfiguration()
	{
		$config = $this->validateConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$dispatchMap = [];
		foreach ($config['dispatchMap'] as $command => $handler) {
			$dispatchMap[preg_replace('~\\\~', '_', $command)] = $handler;
		}

		\Nette\DI\Compiler::loadDefinitions($builder, $dispatchMap);

		$finalDispatchMap = [];
		foreach ($dispatchMap as $command => $handler) {
			$finalDispatchMap[preg_replace('~_~', '\\', $command)] = "@$handler";
		}

		$builder
			->addDefinition($this->prefix('commandBus'))
			->setClass($config['commandBus'])
			->setArguments([
				'dispatchMap' => $finalDispatchMap,
			]);
	}

}
