<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Infrastructure\DI\Nette;

use Adeira\Connector\GraphQL\Infrastructure\DI\Exception\OutputFieldNotCallable;
use Adeira\Connector\GraphQL\Infrastructure\DI\Exception\ResolverNotDefined;
use Tester\Assert;

require getenv('BOOTSTRAP');
require __DIR__ . '/ContainerBuilder.php';

/**
 * @testCase
 */
final class ExtensionMutationsTest extends \Adeira\Connector\Tests\TestCase
{

	public function testMutationsWithoutResolver()
	{
		Assert::exception(function () {
			ContainerBuilder::createContainer(__DIR__ . '/config/mutationsWithoutResolver.neon');
		}, ResolverNotDefined::class, "You must define 'resolver' in 'graphql.mutations.MutationName'.");
	}

	public function testMutationsWithUnknownResolver()
	{
		Assert::exception(function () {
			ContainerBuilder::createContainer(__DIR__ . '/config/mutationsUnknownResolver.neon');
		}, ResolverNotDefined::class, "Resolver class defined in 'graphql.mutations.MutationName' does not exist.");
	}

	public function testMutationsWithoutCallable()
	{
		Assert::exception(function () {
			require __DIR__ . '/NotCallableQueryResolver.php';
			ContainerBuilder::createContainer(__DIR__ . '/config/mutationsWithoutCallable.neon');
		}, OutputFieldNotCallable::class, "Resolver in 'graphql.mutations.MutationName' must implement '__invoke' method.");
	}

	public function testMutationsWithoutNext()
	{
		Assert::exception(function () {
			require __DIR__ . '/QueryResolver.php';
			ContainerBuilder::createContainer(__DIR__ . '/config/mutationsWithoutNext.neon');
		}, \Throwable::class, "You must define next intermediate level in graph using 'next' key.");
	}

	public function testMutations()
	{
		require __DIR__ . '/OutputType.php';
		require __DIR__ . '/QueryResolver.php';
		$container = ContainerBuilder::createContainer(__DIR__ . '/config/mutations.neon');
		$outputType = $container->getByType(\Adeira\Connector\Tests\GraphQL\Infrastructure\DI\Nette\QueryResolver::class);
		Assert::same('Adeira\Connector\Tests\GraphQL\Infrastructure\DI\Nette\QueryResolver::__invoke', $outputType());
	}

}

(new ExtensionMutationsTest)->run();
