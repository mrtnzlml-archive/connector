<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Bridge\Nette\DI;

use Adeira\Connector\GraphQL;

class Extension extends \Adeira\CompilerExtension
{

	public $defaults = [
		'queryDefinitions' => [],
		'mutationDefinitions' => [],
		'types' => [],
	];

	public function provideConfig()
	{
		return __DIR__ . '/config.neon';
	}

	public function loadConfiguration()
	{
		$config = $this->validateConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		// Register GraphQL query definitions
		$queryDefinitions = [];
		foreach ($config['queryDefinitions'] as $definitionName => $definitionClass) {
			if (!is_a($definitionClass, \Adeira\Connector\GraphQL\IQueryDefinition::class, TRUE)) {
				throw new \Adeira\Connector\GraphQL\Exceptions\TypeIsNotValidObjectType($definitionClass);
			}
			$queryDefinitions[] = $builder->addDefinition($this->prefix('queryDefinition.' . $definitionName))->setClass($definitionClass);
		}

		// Register GraphQL mutation definitions
		$mutationDefinitions = [];
		foreach ($config['mutationDefinitions'] as $mutationName => $definitionClass) {
			if (!is_a($definitionClass, \Adeira\Connector\GraphQL\IMutationDefinition::class, TRUE)) {
				throw new \Adeira\Connector\GraphQL\Exceptions\TypeIsNotValidObjectType($definitionClass); //FIXME
			}
			$mutationDefinitions[] = $builder->addDefinition($this->prefix('mutationDefinition.' . $mutationName))->setClass($definitionClass);
		}

		// Register types
		foreach ($config['types'] as $counter => $type) {
			$builder
				->addDefinition($this->prefix('type.' . $counter))
				->setClass($type);
		}

		// Build GraphQL Schema Factory
		$builder
			->addDefinition($this->prefix('schemaFactory'))
			->setClass(GraphQL\SchemaFactory::class)
			->addSetup('?->addQueryDefinitions(?)', ['@self', $queryDefinitions])
			->addSetup('?->addMutationDefinitions(?)', ['@self', $mutationDefinitions]);
	}

}
