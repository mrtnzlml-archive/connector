<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Infrastructure\DI\Nette;

final class Extension extends \Adeira\CompilerExtension
{

	private $scalars = [
		'Int' => 'int',
		'Float' => 'float',
		'String' => 'string',
		'Boolean' => 'boolean',
		'ID' => 'id',
	];

	public function provideConfig()
	{
		return __DIR__ . '/config.neon';
	}

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig([
			'scalars' => [],
			'enums' => [],
			'outputTypes' => [],
			'inputTypes' => [],
			'queries' => [],
			'mutations' => [],
		]);

		foreach ($config['scalars'] as $scalarName => $scalarClass) {
			$builder->addDefinition($this->prefix('scalar.' . $scalarName))->setClass($scalarClass);
		}

		$enums = $config['enums'];

		(new EnumsExtensionStub)->registerEnums($this, $enums);
		(new OutputTypesExtensionStub)->registerOutputTypes($this, $config['outputTypes'], $enums);
		(new InputTypesExtensionStub)->registerInputTypes($this, $config['inputTypes'], $enums);
		(new QueriesExtensionStub)->registerQueries($this, $config['queries']);
		(new MutationsExtensionStub)->registerQueries($this, $config['mutations']);

		$builder
			->addDefinition($this->prefix('schemaFactory'))
			->setClass(\Adeira\Connector\GraphQL\SchemaFactory::class)
			->addSetup('?->addQueryType(?)', ['@self', $builder->getDefinition($this->prefix('query'))])
			->addSetup('?->addMutationType(?)', ['@self', $builder->getDefinition($this->prefix('mutation'))]);
	}

	/**
	 * It resolves $type into GraphQL type:
	 *
	 * Int    => GraphQL\Type\Definition\Type::int()
	 * Int!   => GraphQL\Type\Definition\Type::nonNull( GraphQL\Type\Definition\Type::int() )
	 * [Int!] => GraphQL\Type\Definition\Type::listOf( GraphQL\Type\Definition\Type::nonNull( GraphQL\Type\Definition\Type::int() ) )
	 *
	 * CustomType => Nette\DI\ServiceDefinition with INPUT type, OUTPUT type or ENUM previously registered.
	 *
	 * @param $type array|string
	 *
	 * @return \Nette\DI\Statement | \Nette\DI\ServiceDefinition
	 */
	public function resolveGraphQLType($type)
	{
		$listOf = FALSE;
		if (is_array($type)) {
			$listOf = TRUE;
			$type = $type[0];
		}

		$nonNull = FALSE;
		$pattern = '~(.+)!$~';
		if (preg_match($pattern, $type)) {
			$nonNull = TRUE;
			$type = preg_replace($pattern, '$1', $type);
		}

		if (array_key_exists($type, $this->scalars)) {
			$type = new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::?()', [$this->scalars[$type]]);
		} else {
			$type = $this->getTypeDefinition($type);
		}

		if ($nonNull) {
			$type = new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::nonNull(?)', [$type]);
		}
		if ($listOf) {
			return new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::listOf(?)', [$type]);
		}
		return $type;
	}

	public function getTypeDefinition(string $name): \Nette\DI\ServiceDefinition
	{
		$builder = $this->getContainerBuilder();
		$definition = NULL;
		$allowedNamespaces = ['scalar', 'inputType', 'outputType', 'enum'];
		foreach ($allowedNamespaces as $namespace) {
			if ($builder->hasDefinition($this->prefix("$namespace.$name"))) {
				$definition = $builder->getDefinition($this->prefix("$namespace.$name"));
				break;
			}
		}

		if ($definition === NULL) {
			throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\UnknownTypeDefinition(
				"Cannot find definition for type '$name'. Did you register it in configuration file?"
			);
		}
		return $definition;
	}

}
