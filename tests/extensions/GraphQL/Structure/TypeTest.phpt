<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Structure;

use Adeira\Connector\GraphQL\Structure\{
	Field, Type
};
use function Adeira\Connector\GraphQL\{
	id, nullableString
};
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class TypeTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatMinimalStructureWorks()
	{
		/** @var Type $type */
		$type = new class extends Type {
			public function getPublicTypeName(): string { return 'WeatherStation'; }
			public function getPublicTypeDescription(): string { return 'Weather Station Description'; }
			public function defineFields(): array {
				return [
					new Field('id', 'ID of the Weather Station', id()),
					new Field('name', 'Name of the weather station', nullableString()),
				];
			}
		};

		Assert::equal(
			[
				'name' => 'WeatherStation',
				'description' => 'Weather Station Description',
				'fields' => [
					'id' => [
						'type' => id(),
						'description' => 'ID of the Weather Station',
						'args' => NULL,
						'resolve' => NULL,
					],
					'name' => [
						'type' => nullableString(),
						'description' => 'Name of the weather station',
						'args' => NULL,
						'resolve' => NULL,
					],
				],
			],
			$type->constructTypeArrayDefinition()
		);
	}

	public function testThatFullStructureWorks()
	{
		/** @var Type $type */
		$type = new class extends Type {
			public function getPublicTypeName(): string { return 'WeatherStation'; }
			public function getPublicTypeDescription(): string { return 'Weather Station Description'; }
			public function defineFields(): array {
				$f1 = new Field('id', 'ID of the Weather Station', id());
				$f1->setResolveFunction(function() {});
				$f2 = new Field('name', 'Name of the weather station', nullableString());
				$f2->setResolveFunction(function() {});
				return [$f1, $f2];
			}
		};

		Assert::equal(
			[
				'name' => 'WeatherStation',
				'description' => 'Weather Station Description',
				'fields' => [
					'id' => [
						'type' => id(),
						'description' => 'ID of the Weather Station',
						'args' => NULL,
						'resolve' => function() {},
					],
					'name' => [
						'type' => nullableString(),
						'description' => 'Name of the weather station',
						'args' => NULL,
						'resolve' => function() {},
					],
				],
			],
			$type->constructTypeArrayDefinition()
		);
	}

}

(new TypeTest)->run();
