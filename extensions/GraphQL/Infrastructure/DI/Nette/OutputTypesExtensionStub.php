<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Infrastructure\DI\Nette;

final class OutputTypesExtensionStub
{

	public function registerOutputTypes(Extension $extension, array $outputTypes)
	{
		$builder = $extension->getContainerBuilder();

		// first register all types
		foreach ($outputTypes as $typeName => $typeDetails) {
			$builder
				->addDefinition($extension->prefix("outputType.$typeName"))
				->setClass(\GraphQL\Type\Definition\ObjectType::class);
		}

		// now configure all types
		foreach ($outputTypes as $typeName => $typeDetails) {
			if (!isset($typeDetails['resolver'])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\ResolverNotDefined(
					"You must define 'resolver' in '{$extension->prefix('outputType')}.$typeName'."
				);
			}
			$resolverDefinition = $builder->addDefinition($extension->prefix('outputTypeResolver.' . $typeName))->setClass($typeDetails['resolver']);
			$builder
				->getDefinition($extension->prefix("outputType.$typeName"))
				->setArguments([
					'config' => [
						'name' => $typeName,
						'fields' => $this->buildOutputFields($extension, $typeDetails['fields'], $resolverDefinition),
					],
				]);
		}
	}

	private function buildOutputFields(Extension $extension, array $fields, \Nette\DI\ServiceDefinition $resolverDefinition)
	{
		$output = [];
		foreach ($fields as $fieldName => $fieldDetails) {

			if (!is_callable([$resolverDefinition->class, $fieldName])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\OutputFieldNotCallable(
					"You must implement method '$fieldName' in class '$resolverDefinition->class'."
				);
			}

			$output[$fieldName] = [
				'type' => $extension->resolveGraphQLType($fieldDetails),
				'resolve' => [$resolverDefinition, $fieldName],
			];
		}
		return $output;
	}

}
