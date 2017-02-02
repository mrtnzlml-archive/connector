<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL;

use Adeira\Connector\GraphQL\Executor;
use function Adeira\Connector\GraphQL\string;
use GraphQL\Type\Definition\ResolveInfo;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class ExecutorTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatClosureIsExecuted()
	{
		Assert::same('OK', Executor::defaultFieldResolver(function () {
			return 'OK';
		}, [], NULL, new ResolveInfo(['fieldName' => 'mock'])));
	}

	public function testThatArrayIsReturned()
	{
		Assert::same(
			['array'],
			Executor::defaultFieldResolver(['array'], [], NULL, new ResolveInfo(['fieldName' => 'mock']))
		);
	}

	public function testThatObjectIsReturned()
	{
		$object = new \stdClass;
		Assert::same(
			$object,
			Executor::defaultFieldResolver($object, [], NULL, new ResolveInfo(['fieldName' => 'mock']))
		);
	}

	public function testThatObjectIsNotIntrospected()
	{
		$object = new class {
			public $description = 'should not be introspected';
		};
		Assert::same(
			$object, //original object (without property introspection)
			Executor::defaultFieldResolver($object, [], NULL, new ResolveInfo(['fieldName' => 'description']))
		);
	}

	public function testThatIntrospectionWorks()
	{
		$object = \GraphQL\Type\Definition\FieldDefinition::create([
			'name' => 'mock',
			'type' => string(),
			'description' => 'tadá',
		]);
		Assert::same(
			'tadá', //introspected field
			Executor::defaultFieldResolver($object, [], NULL, new ResolveInfo(['fieldName' => 'description']))
		);
	}

}

(new ExecutorTest)->run();
