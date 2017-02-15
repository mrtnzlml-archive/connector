<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Bridge\Nette\DI;

use Adeira\Connector\GraphQL;

class Extension extends \Adeira\CompilerExtension
{

	public function provideConfig()
	{
		return __DIR__ . '/config.neon';
	}

	public function loadConfiguration()
	{
		$config = $this->validateConfig([
			'types' => [],
		]);
		$builder = $this->getContainerBuilder();
		$queryDefinitions = $mutationDefinitions = [];

		// Register types
		foreach ($config['types'] as $counter => $type) {
			if (is_a($type, GraphQL\Structure\Query::class, TRUE)) {
				$queryDefinitions[] = $builder->addDefinition($this->prefix('queryDefinition.' . $counter))->setClass($type);
			} elseif (is_a($type, GraphQL\Structure\Mutation::class, TRUE)) {
				$mutationDefinitions[] = $builder->addDefinition($this->prefix('mutationDefinition.' . $counter))->setClass($type);
			} else {
				$builder
					->addDefinition($this->prefix('type.' . $counter))
					->setClass($type);
			}
		}

		// Build GraphQL Schema Factory
		$builder
			->addDefinition($this->prefix('schemaFactory'))
			->setClass(GraphQL\SchemaFactory::class)
			->addSetup('?->addQueryDefinitions(?)', ['@self', $queryDefinitions])
			->addSetup('?->addMutationDefinitions(?)', ['@self', $mutationDefinitions]);
	}

}
