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
final class ExtensionQueriesTest extends \Adeira\Connector\Tests\TestCase
{

	public function testQueriesWithoutResolver()
	{
		Assert::exception(function () {
			ContainerBuilder::createContainer(__DIR__ . '/config/queriesWithoutResolver.neon');
		}, ResolverNotDefined::class, "You must define 'resolver' in 'graphql.queries.QueryName'.");
	}

	public function testQueriesWithUnknownResolver()
	{
		Assert::exception(function () {
			ContainerBuilder::createContainer(__DIR__ . '/config/queriesUnknownResolver.neon');
		}, ResolverNotDefined::class, "Resolver class defined in 'graphql.queries.QueryName' does not exist.");
	}

	public function testQueriesWithoutCallable()
	{
		Assert::exception(function () {
			require __DIR__ . '/NotCallableQueryResolver.php';
			ContainerBuilder::createContainer(__DIR__ . '/config/queriesWithoutCallable.neon');
		}, OutputFieldNotCallable::class, "Resolver in 'graphql.queries.QueryName' must implement '__invoke' method.");
	}

	public function testQueriesWithoutNext()
	{
		Assert::exception(function () {
			require __DIR__ . '/QueryResolver.php';
			ContainerBuilder::createContainer(__DIR__ . '/config/queriesWithoutNext.neon');
		}, \Throwable::class, "You must define next intermediate level in graph using 'next' key.");
	}

	public function testQueries()
	{
		require __DIR__ . '/OutputType.php';
		require __DIR__ . '/QueryResolver.php';
		$container = ContainerBuilder::createContainer(__DIR__ . '/config/queries.neon');
		$outputType = $container->getByType(\Adeira\Connector\Tests\GraphQL\Infrastructure\DI\Nette\QueryResolver::class);
		Assert::same('Adeira\Connector\Tests\GraphQL\Infrastructure\DI\Nette\QueryResolver::__invoke', $outputType());
	}

}

(new ExtensionQueriesTest)->run();
