<?php declare(strict_types = 1);

namespace Adeira\Connector\Symfony\Console\DI;

use Nette\DI;

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
			if (!is_array($commandClass)) {
				$commandClass = ['class' => $commandClass];
			}
			$defName = $this->prefix('command.' . $commandName);
			DI\Compiler::loadDefinitions($builder, [
				$defName => $commandClass + ['inject' => TRUE],
			]);
			$commandServices[$commandName] = $builder->getDefinition($defName);
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
