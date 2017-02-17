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
final class ExtensionOutputTypesTest extends \Adeira\Connector\Tests\TestCase
{

	public function testOutputTypesWithoutResolver()
	{
		Assert::exception(function () {
			ContainerBuilder::createContainer(__DIR__ . '/config/outputTypesWithoutResolver.neon');
		}, ResolverNotDefined::class, "You must define 'resolver' in 'graphql.outputType.TypeName'.");
	}

	public function testOutputTypesWithoutCallable()
	{
		Assert::exception(function () {
			ContainerBuilder::createContainer(__DIR__ . '/config/outputTypesWithoutCallable.neon');
		}, OutputFieldNotCallable::class, "You must implement method 'totalCount' in class 'ThisIsNotCallable'.");
	}

	public function testOutputTypes()
	{
		require __DIR__ . '/OutputType.php';
		$container = ContainerBuilder::createContainer(__DIR__ . '/config/outputTypes.neon');
		$outputType = $container->getByType(\Adeira\Connector\Tests\GraphQL\Infrastructure\DI\Nette\OutputType::class);
		Assert::same(42, $outputType->totalCount());
	}

}

(new ExtensionOutputTypesTest)->run();
