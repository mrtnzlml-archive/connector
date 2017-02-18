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
			'enums' => [],
			'outputTypes' => [],
			'inputTypes' => [],
			'queries' => [],
			'mutations' => [],
		]);

		$enums = $config['enums'];

		(new EnumsExtensionStub)->registerEnums($this, $enums);
		(new OutputTypesExtensionStub)->registerOutputTypes($this, $config['outputTypes']);
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
		if ($builder->hasDefinition($this->prefix('inputType.' . $name))) {
			return $builder->getDefinition($this->prefix('inputType.' . $name));
		} elseif ($builder->hasDefinition($this->prefix('outputType.' . $name))) {
			return $builder->getDefinition($this->prefix('outputType.' . $name));
		} else {
			return $builder->getDefinition($this->prefix('enum.' . $name));
		}
	}

}
