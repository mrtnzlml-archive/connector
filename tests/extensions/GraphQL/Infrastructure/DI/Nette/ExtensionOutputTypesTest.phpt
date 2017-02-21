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

		/** @var \GraphQL\Type\Definition\ObjectType $inputType */
		$inputType = $container->getService('graphql.outputType.TypeName');
		Assert::equal([
			'name' => 'TypeName',
			'fields' => [
				'totalCount' => [
					'type' => \GraphQL\Type\Definition\Type::listOf(\GraphQL\Type\Definition\Type::nonNull(\GraphQL\Type\Definition\Type::int())),
					'resolve' => [
						$container->getService('graphql.outputTypeResolver.TypeName'),
						'totalCount',
					],
				],
				'allRecords' => [
					'type' => \GraphQL\Type\Definition\Type::listOf(\GraphQL\Type\Definition\Type::string()),
					'resolve' => [
						$container->getService('graphql.outputTypeResolver.TypeName'),
						'allRecords',
					],
					'args' => [
						'id' => [
							'type' => \GraphQL\Type\Definition\Type::nonNull(\GraphQL\Type\Definition\Type::id()),
							'defaultValue' => NULL,
						],
						'name' => [
							'type' => \GraphQL\Type\Definition\Type::string(),
							'defaultValue' => 'test',
						],
						'fromEnum' => [
							'type' => new \GraphQL\Type\Definition\EnumType([
								'name' => 'EnumName',
								'values' => [
									'key' => 'value',
								],
							]),
							'defaultValue' => 'value',
						],
					],
				],
			],
		], $inputType->config);
	}

}

(new ExtensionOutputTypesTest)->run();
