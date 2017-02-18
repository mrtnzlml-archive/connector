<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Infrastructure\DI\Nette;

final class QueriesExtensionStub
{

	public function registerQueries(Extension $extension, array $queries)
	{
		$builder = $extension->getContainerBuilder();

		$fields = [];
		foreach ($queries as $queryName => $queryDetails) {

			if (!isset($queryDetails['resolver'])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\ResolverNotDefined(
					"You must define 'resolver' in '{$extension->prefix('queries')}.$queryName'."
				);
			}

			if (!class_exists($queryDetails['resolver'])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\ResolverNotDefined(
					"Resolver class defined in '{$extension->prefix('queries')}.$queryName' does not exist."
				);
			}

			if (!(new \ReflectionClass($queryDetails['resolver']))->hasMethod('__invoke')) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\OutputFieldNotCallable(
					"Resolver in '{$extension->prefix('queries')}.$queryName' must implement '__invoke' method."
				);
			}

			if (!isset($queryDetails['next'])) {
				throw new \Exception("You must define next intermediate level in graph using 'next' key.");
			}

			$fields[$queryName] = [
				'type' => $extension->getTypeDefinition($queryDetails['next']),
				'resolve' => $builder->addDefinition($extension->prefix('queryResolver.' . $queryName))->setClass($queryDetails['resolver']),
			];
			if (isset($queryDetails['arguments'])) {
				$fields[$queryName]['args'] = $this->buildArguments($extension, $queryDetails['arguments']);
			}
		}

		$builder
			->addDefinition($extension->prefix('query'))
			->setClass(\GraphQL\Type\Definition\ObjectType::class)
			->setArguments([
				'config' => [
					'name' => 'Query',
					'fields' => $fields,
				],
			]);
	}

	private function buildArguments(Extension $extension, array $arguments)
	{
		$output = [];
		foreach ($arguments as $argumentName => $argumentDetails) {
			$output[$argumentName] = [
				'type' => $extension->resolveGraphQLType($argumentDetails),
			];
		}
		return $output;
	}

}
