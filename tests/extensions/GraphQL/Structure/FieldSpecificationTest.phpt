<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Structure;

use Adeira\Connector\GraphQL\Structure\{
	FieldSpecification
};
use GraphQL\Type\Definition;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class FieldSpecificationTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatMinimalStructureWorks()
	{
		$field = new FieldSpecification(':name', ':description', Definition\Type::string());

		Assert::equal(
			[
				':name' => [
					'type' => Definition\Type::string(),
					'description' => ':description',
					'args' => NULL,
					'resolve' => NULL,
				],
			],
			$field->buildArray()
		);
	}

}

(new FieldSpecificationTest)->run();
