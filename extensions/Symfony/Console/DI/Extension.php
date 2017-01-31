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

		// Make all commands named services (so we can find and register them later)
		$commands = [];
		$iterator = 1;
		foreach ($config['commands'] as $commandName => $commandClass) {
			if ((string)(int)$commandName === (string)$commandName) { //anonymous
				$commands['_' . $iterator++] = $commandClass;
			} else {
				$commands[$commandName] = $commandClass;
			}
		}

		// Register commands as services (so DI will work as expected)
		DI\Compiler::loadDefinitions($builder, $commands, $this->prefix('command'));

		// Get registered commands definitions and register them in Symfony Application
		$commandDefinitions = [];
		foreach ($builder->findByTag('kdyby.console.command') as $commandName => $commandClass) { //compatibility with Kdyby
			$commandDefinitions[$commandName] = '@' . $commandName;
		}
		foreach ($commands as $commandName => $commandClass) {
			$commandDefinitions[$commandName] = '@' . $this->prefix('command') . ".$commandName";
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
				$commandDefinitions,
			]);
	}

}
