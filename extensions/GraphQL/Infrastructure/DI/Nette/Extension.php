<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Infrastructure\DI\Nette;

use Adeira\Connector\GraphQL\DomainModel\Structure\EnumBuilder;
use Adeira\Connector\GraphQL\DomainModel\Structure\FieldBuilder;
use Nette\DI\ContainerBuilder;
use Nette\DI\ServiceDefinition;
use Nette\DI\Statement;

final class Extension extends \Adeira\CompilerExtension
{

	public function provideConfig()
	{
		return __DIR__ . '/config.neon';
	}

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig([
			'enums' => [],
			'outputTypes' => [],
			'inputTypes' => [],
			'queries' => [],
			'mutations' => [],
		]);

		$enums = $config['enums'];
		$outputTypes = $config['outputTypes'];
		$inputTypes = $config['inputTypes'];
		$queries = $config['queries'];
		$mutations = $config['mutations'];

		$this->registerEnums($builder, $enums);
		$this->registerOutputTypes($builder, $outputTypes);
		$this->registerInputTypes($builder, $inputTypes, $enums);
		$this->registerQueries($builder, $queries);
		$this->registerMutations($builder, $mutations);

		$builder
			->addDefinition($this->prefix('schemaFactory'))
			->setClass(\Adeira\Connector\GraphQL\SchemaFactory::class)
			->addSetup('?->addQueryType(?)', ['@self', $builder->getDefinition($this->prefix('query'))])
			->addSetup('?->addMutationType(?)', ['@self', $builder->getDefinition($this->prefix('mutation'))]);
	}

	private function registerEnums(ContainerBuilder $builder, array $enums)
	{
		foreach ($enums as $enumName => $enumDetails) {
			$builder
				->addDefinition($this->prefix("enum.$enumName"))
				->setClass(\GraphQL\Type\Definition\EnumType::class)
				->setArguments(EnumBuilder::buildEnumArrayStructure($enumName, $enumDetails));
		}
	}

	/**
	 * Output types MUST have resolver class.
	 */
	private function registerOutputTypes(ContainerBuilder $builder, array $outputTypes)
	{
		// first register all types
		foreach ($outputTypes as $typeName => $typeDetails) {
			$builder
				->addDefinition($this->prefix("outputType.$typeName"))
				->setClass(\GraphQL\Type\Definition\ObjectType::class);
		}

		// now configure all types
		foreach ($outputTypes as $typeName => $typeDetails) {
			if (!isset($typeDetails['resolver'])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\ResolverNotDefined(
					"You must define 'resolver' in '{$this->prefix('outputType')}.$typeName'."
				);
			}
			$resolverDefinition = $builder->addDefinition($this->prefix('outputTypeResolver.' . $typeName))->setClass($typeDetails['resolver']);
			$builder
				->getDefinition($this->prefix("outputType.$typeName"))
				->setArguments([
					'config' => [
						'name' => $typeName,
						'fields' => $this->buildOutputFields($typeDetails['fields'], $resolverDefinition),
					],
				]);
		}
	}

	private function buildOutputFields(array $fields, ServiceDefinition $resolverDefinition)
	{
		$output = [];
		foreach ($fields as $fieldName => $fieldDetails) {

			if (!is_callable([$resolverDefinition->class, $fieldName])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\OutputFieldNotCallable(
					"You must implement method '$fieldName' in class '$resolverDefinition->class'."
				);
			}

			$output[$fieldName] = [
				'type' => $this->buildFieldType($fieldDetails),
				'resolve' => [$resolverDefinition, $fieldName],
			];
		}
		return $output;
	}

	/**
	 * Input types doesn't have resolver not fields.
	 */
	private function registerInputTypes(ContainerBuilder $builder, array $inputTypes, array $allEnumValues)
	{
		// first register all types
		foreach ($inputTypes as $typeName => $typeDetails) {
			$builder
				->addDefinition($this->prefix("inputType.$typeName"))
				->setClass(\GraphQL\Type\Definition\InputObjectType::class);
		}

		// now configure all types
		foreach ($inputTypes as $typeName => $inputFields) {
			$builder
				->getDefinition($this->prefix("inputType.$typeName"))
				->setArguments([
					'config' => [
						'name' => $typeName,
						'fields' => $this->buildInputFields($inputFields, $allEnumValues),
					],
				]);
		}
	}

	private function buildInputFields(array $inputFields, array $allEnumValues)
	{
		$output = [];
		foreach ($inputFields as $fieldName => $fieldType) {
			$defaultValue = NULL;
			if ($fieldType instanceof Statement) {
				$default = $fieldType->arguments['default'];
				$fieldType = $fieldType->getEntity();
				$response = FieldBuilder::resolveField($fieldType);
				if ($response->isScalar()) {
					$defaultValue = $default;
				} else { // it MUST be enum then
					$defaultValue = $allEnumValues[$fieldType][$default];
				}
			}
			$output[$fieldName] = [
				'type' => $this->buildFieldType($fieldType),
				'defaultValue' => $defaultValue,
			];
		}
		return $output;
	}

	private function registerQueries(ContainerBuilder $builder, array $queries)
	{
		$fields = []; //FIXME: this is just special case of fields
		foreach ($queries as $queryName => $queryDetails) {

			if (!isset($queryDetails['resolver'])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\ResolverNotDefined(
					"You must define 'resolver' in '{$this->prefix('queries')}.$queryName'."
				);
			}

			if (!class_exists($queryDetails['resolver'])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\ResolverNotDefined(
					"Resolver class defined in '{$this->prefix('queries')}.$queryName' does not exist."
				);
			}

			if (!(new \ReflectionClass($queryDetails['resolver']))->hasMethod('__invoke')) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\OutputFieldNotCallable(
					"Resolver in '{$this->prefix('queries')}.$queryName' must implement '__invoke' method."
				);
			}

			if (!isset($queryDetails['next'])) {
				throw new \Exception("You must define next intermediate level in graph using 'next' key.");
			}

			$fields[$queryName] = [
				'type' => $this->getTypeByName($queryDetails['next']),
				'resolve' => $builder->addDefinition($this->prefix('queryResolver.' . $queryName))->setClass($queryDetails['resolver']),
			];
			if (isset($queryDetails['arguments'])) {
				$fields[$queryName]['args'] = $this->buildArguments($queryDetails['arguments']);
			}
		}

		$builder
			->addDefinition($this->prefix('query'))
			->setClass(\GraphQL\Type\Definition\ObjectType::class)
			->setArguments([
				'config' => [
					'name' => 'Query',
					'fields' => $fields,
				],
			]);
	}

	private function registerMutations(ContainerBuilder $builder, array $mutations)
	{
		$fields = []; //FIXME: this is just special case of fields
		foreach ($mutations as $mutationName => $mutationDetails) {

			if (!isset($mutationDetails['resolver'])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\ResolverNotDefined(
					"You must define 'resolver' in '{$this->prefix('mutations')}.$mutationName'."
				);
			}

			if (!class_exists($mutationDetails['resolver'])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\ResolverNotDefined(
					"Resolver class defined in '{$this->prefix('mutations')}.$mutationName' does not exist."
				);
			}

			if (!(new \ReflectionClass($mutationDetails['resolver']))->hasMethod('__invoke')) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\OutputFieldNotCallable(
					"Resolver in '{$this->prefix('mutations')}.$mutationName' must implement '__invoke' method."
				);
			}

			if (!isset($mutationDetails['next'])) {
				throw new \Exception("You must define next intermediate level in graph using 'next' key.");
			}

			$fields[$mutationName] = [
				'type' => $this->getTypeByName($mutationDetails['next']),
				'resolve' => $builder->addDefinition($this->prefix($mutationName))->setClass($mutationDetails['resolver']),
			];
			if (isset($mutationDetails['arguments'])) {
				$fields[$mutationName]['args'] = $this->buildArguments($mutationDetails['arguments']);
			}
		}

		$builder
			->addDefinition($this->prefix('mutation'))
			->setClass(\GraphQL\Type\Definition\ObjectType::class)
			->setArguments([
				'config' => [
					'name' => 'Mutation',
					'fields' => $fields,
				],
			]);
	}

	private function buildArguments(array $arguments)
	{
		$output = [];
		foreach ($arguments as $argumentName => $argumentDetails) {
			$output[$argumentName] = [
				'type' => $this->buildFieldType($argumentDetails),
			];
		}
		return $output;
	}

	/**
	 * @param $fieldType array|string
	 */
	private function buildFieldType($fieldType)
	{
		$response = FieldBuilder::resolveField($fieldType);
		$fieldType = $response->value();

		if ($response->isScalar()) {
			$fieldType = new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::?()', [$response->value()]);
		} else {
			$fieldType = $this->getTypeByName($fieldType);
		}

		if ($response->isNonNull()) {
			$fieldType = new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::nonNull(?)', [$fieldType]);
		}
		if ($response->isListOf()) {
			return new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::listOf(?)', [$fieldType]);
		}
		return $fieldType;
	}

	private function getTypeByName(string $name)
	{
		$builder = $this->getContainerBuilder();
		if ($builder->hasDefinition($this->prefix('inputType.' . $name))) {
			return $builder->getDefinition($this->prefix('inputType.' . $name));
		} elseif ($builder->hasDefinition($this->prefix('outputType.' . $name))) {
			return $builder->getDefinition($this->prefix('outputType.' . $name));
		} else {
			return $builder->getDefinition($this->prefix('enum.' . $name));
		}
	}

}
