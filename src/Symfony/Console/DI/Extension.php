<?php declare(strict_types = 1);

namespace Adeira\Connector\Symfony\Console\DI;

final class Extension extends \Nette\DI\CompilerExtension
{

	private $defaults = [
		'commands' => [],
		'helpers' => [],
	];

	public function loadConfiguration()
	{
		$config = $this->validateConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$helperServices = [];
		foreach ($config['helpers'] as $helperName => $helperClass) {
			$helperServices[$helperName] = $builder->addDefinition($this->prefix('helper.' . $helperName))->setClass($helperClass);
		}

		$commandServices = [];
		foreach ($config['commands'] as $commandName => $commandClass) {
			$commandServices[$commandName] = $builder->addDefinition($this->prefix('command.' . $commandName))->setClass($commandClass);
		}

		$builder
			->addDefinition($this->prefix('application'))
			->setClass(\Symfony\Component\Console\Application::class)
			->addSetup('?->setHelperSet(new \Symfony\Component\Console\Helper\HelperSet(?))', [
				'@self',
				$helperServices,
			])
			->addSetup('?->addCommands(?)', [
				'@self',
				$commandServices,
			]);
	}

}
