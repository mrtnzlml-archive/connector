<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Infrastructure\DI\Nette;

final class OutputTypesExtensionStub
{

	public function registerOutputTypes(Extension $extension, array $outputTypes, array $allEnumValues)
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

			$resolverDefinition = $builder->addDefinition($extension->prefix('outputTypeResolver.' . $typeName));
			if($typeDetails['resolver'] instanceof \Nette\DI\Statement) {
				$class = $typeDetails['resolver']->getEntity();
				$args = \Nette\DI\Helpers::expand($typeDetails['resolver']->arguments, $builder->parameters);
				$resolverDefinition->setClass($class, $args);
			} else {
				$resolverDefinition->setClass($typeDetails['resolver']);
			}

			$builder
				->getDefinition($extension->prefix("outputType.$typeName"))
				->setArguments([
					'config' => [
						'name' => $typeName,
						'fields' => $this->buildOutputFields(
							$extension,
							$typeDetails['fields'],
							$resolverDefinition,
							$allEnumValues
						),
					],
				]);
		}
	}

	private function buildOutputFields(Extension $extension, array $fields, \Nette\DI\ServiceDefinition $resolverDefinition, array $allEnumValues)
	{
		$output = [];
		foreach ($fields as $fieldName => $fieldDetails) {

			if (!is_callable([$resolverDefinition->class, $fieldName])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\OutputFieldNotCallable(
					"You must implement method '$fieldName' in class '$resolverDefinition->class'."
				);
			}

			if (is_array($fieldDetails) && isset($fieldDetails['next'], $fieldDetails['arguments'])) { // output type with 'arguments' and 'next'
				$type = $fieldDetails['next'];
			} else { // simple output type definition
				$type = $fieldDetails;
			}

			$output[$fieldName] = [
				'type' => $extension->resolveGraphQLType($type),
				'resolve' => [$resolverDefinition, $fieldName],
			];
			if (isset($fieldDetails['arguments'])) {
				$output[$fieldName]['args'] = $this->buildArguments($extension, $fieldDetails['arguments'], $allEnumValues);
			}
		}
		return $output;
	}

	/**
	 * FIXME: this is just copy-paste!
	 */
	private function buildArguments(Extension $extension, array $arguments, array $allEnumValues)
	{
		$output = [];
		foreach ($arguments as $argumentName => $argumentDetails) {

			$defaultValue = NULL;
			if ($argumentDetails instanceof \Nette\DI\Statement) {
				$default = $argumentDetails->arguments['default'];
				$argumentDetails = $argumentDetails->getEntity();
				if ($extension->resolveGraphQLType($argumentDetails) instanceof \Nette\DI\Statement) { // It is scalar! ... Float(default: 1.0)
					$defaultValue = $default;
				} else { // Ok, it's not scalar - it MUST be enum then! ... PressureUnit(default: PASCAL)
					$defaultValue = $allEnumValues[$argumentDetails][$default];
				}
			}

			$output[$argumentName] = [
				'type' => $extension->resolveGraphQLType($argumentDetails),
				'defaultValue' => $defaultValue,
			];
		}
		return $output;
	}

}
