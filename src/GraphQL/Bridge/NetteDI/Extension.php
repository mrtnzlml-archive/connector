<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Bridge\NetteDI;

use Adeira\Connector\GraphQL;

class Extension extends \Adeira\CompilerExtension
{

	public $defaults = [
		'interfaces' => [],
		'types' => [],
		'queryType' => NULL,
		'mutationType' => NULL,
	];

	public function loadConfiguration()
	{
		$config = $this->validateConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		// Just register GraphQL interfaces
		foreach ($config['interfaces'] as $interfaceName => $interfaceClass) {
			if (!is_a($interfaceClass, \Adeira\Connector\GraphQL\IInterface::class, TRUE)) {
				throw new \Adeira\Connector\GraphQL\Exceptions\InterfaceIsNotValidObjectType($interfaceClass);
			}
			$builder->addDefinition($this->prefix('interface.' . $interfaceName))->setClass($interfaceClass);
		}

		// Register GraphQL types
		$types = [];
		foreach ($config['types'] as $typeName => $typeClass) {
			if (!is_a($typeClass, \Adeira\Connector\GraphQL\IType::class, TRUE)) {
				throw new \Adeira\Connector\GraphQL\Exceptions\TypeIsNotValidObjectType($typeClass);
			}
			$types[] = $builder->addDefinition($this->prefix('type.' . $typeName))->setClass($typeClass);
		}

		// Build GraphQL Schema Factory
		$builder
			->addDefinition($this->prefix('schemaFactory'))
			->setClass(GraphQL\SchemaFactory::class)
			->addSetup('?->addTypes(?)', ['@self', $types]);
	}

}
