<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Structure;

use Adeira\Connector\GraphQL\Structure\{
	FieldSpecification, TypeSpecification
};
use GraphQL\Type\Definition;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class TypeSpecificationTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatMinimalStructureWorks()
	{
		$type = new TypeSpecification('WeatherStation', 'Weather Station Description');
		$type->addField(new FieldSpecification('id', 'ID of the Weather Station', new Definition\NonNull(Definition\Type::string())));
		$type->addField(new FieldSpecification('name', 'Name of the weather station', Definition\Type::string()));

		Assert::equal(
			[
				'name' => 'WeatherStation',
				'description' => 'Weather Station Description',
				'fields' => [
					'id' => [
						'type' => new Definition\NonNull(Definition\Type::string()),
						'description' => 'ID of the Weather Station',
						'args' => NULL,
						'resolve' => NULL,
					],
					'name' => [
						'type' => Definition\Type::string(),
						'description' => 'Name of the weather station',
						'args' => NULL,
						'resolve' => NULL,
					],
				],
			],
			$type->buildArray()
		);
	}

	public function testThatFullStructureWorks()
	{
		$type = new TypeSpecification('WeatherStation', 'Weather Station Description');

		$idField = new FieldSpecification('id', 'ID of the Weather Station', new Definition\NonNull(Definition\Type::string()));
		$idField->setResolveFunction([$this, 'callableMock']);
		$type->addField($idField);

		$nameField = new FieldSpecification('name', 'Name of the weather station', Definition\Type::string());
		$nameField->setResolveFunction([$this, 'callableMock']);
		$type->addField($nameField);

		Assert::equal(
			[
				'name' => 'WeatherStation',
				'description' => 'Weather Station Description',
				'fields' => [
					'id' => [
						'type' => new Definition\NonNull(Definition\Type::string()),
						'description' => 'ID of the Weather Station',
						'args' => NULL,
						'resolve' => [$this, 'callableMock'],
					],
					'name' => [
						'type' => Definition\Type::string(),
						'description' => 'Name of the weather station',
						'args' => NULL,
						'resolve' => [$this, 'callableMock'],
					],
				],
			],
			$type->buildArray()
		);
	}

	public function callableMock()
	{
	}

}

(new TypeSpecificationTest)->run();
