<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Infrastructure\DI\Nette;

final class MutationsExtensionStub
{

	public function registerQueries(Extension $extension, array $mutations)
	{
		$builder = $extension->getContainerBuilder();

		$fields = [];
		foreach ($mutations as $mutationName => $mutationDetails) {

			if (!isset($mutationDetails['resolver'])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\ResolverNotDefined(
					"You must define 'resolver' in '{$extension->prefix('mutations')}.$mutationName'."
				);
			}

			if (!class_exists($mutationDetails['resolver'])) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\ResolverNotDefined(
					"Resolver class defined in '{$extension->prefix('mutations')}.$mutationName' does not exist."
				);
			}

			if (!(new \ReflectionClass($mutationDetails['resolver']))->hasMethod('__invoke')) {
				throw new \Adeira\Connector\GraphQL\Infrastructure\DI\Exception\OutputFieldNotCallable(
					"Resolver in '{$extension->prefix('mutations')}.$mutationName' must implement '__invoke' method."
				);
			}

			if (!isset($mutationDetails['next'])) {
				throw new \Exception("You must define next intermediate level in graph using 'next' key.");
			}

			$fields[$mutationName] = [
				'type' => $extension->getTypeDefinition($mutationDetails['next']),
				'resolve' => $builder->addDefinition($extension->prefix($mutationName))->setClass($mutationDetails['resolver']),
			];
			if (isset($mutationDetails['arguments'])) {
				$fields[$mutationName]['args'] = $this->buildArguments($extension, $mutationDetails['arguments']);
			}
		}

		$builder
			->addDefinition($extension->prefix('mutation'))
			->setClass(\GraphQL\Type\Definition\ObjectType::class)
			->setArguments([
				'config' => [
					'name' => 'Mutation',
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
