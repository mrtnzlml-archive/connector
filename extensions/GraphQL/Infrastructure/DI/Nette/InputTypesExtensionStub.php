<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Infrastructure\DI\Nette;

final class InputTypesExtensionStub
{

	public function registerInputTypes(Extension $extension, array $inputTypes, array $allEnumValues)
	{
		$builder = $extension->getContainerBuilder();

		// first register all types
		foreach ($inputTypes as $typeName => $typeDetails) {
			$builder
				->addDefinition($extension->prefix("inputType.$typeName"))
				->setClass(\GraphQL\Type\Definition\InputObjectType::class);
		}

		// now configure all types
		foreach ($inputTypes as $typeName => $inputFields) {
			$builder
				->getDefinition($extension->prefix("inputType.$typeName"))
				->setArguments([
					'config' => [
						'name' => $typeName,
						'fields' => $this->buildInputFields($extension, $inputFields, $allEnumValues),
					],
				]);
		}
	}

	private function buildInputFields(Extension $extension, array $inputFields, array $allEnumValues)
	{
		$output = [];
		foreach ($inputFields as $fieldName => $fieldType) {
			$defaultValue = NULL;
			if ($fieldType instanceof \Nette\DI\Statement) {
				$default = $fieldType->arguments['default'];
				$fieldType = $fieldType->getEntity();
				if ($extension->resolveGraphQLType($fieldType) instanceof \Nette\DI\Statement) { // It is scalar! ... Float(default: 1.0)
					$defaultValue = $default;
				} else { // Ok, it's not scalar - it MUST be enum then! ... PressureUnit(default: PASCAL)
					$defaultValue = $allEnumValues[$fieldType][$default];
				}
			}
			$output[$fieldName] = [
				'type' => $extension->resolveGraphQLType($fieldType),
				'defaultValue' => $defaultValue,
			];
		}
		return $output;
	}

}
