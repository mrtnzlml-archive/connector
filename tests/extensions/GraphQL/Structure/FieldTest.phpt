<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Structure;

use Adeira\Connector\GraphQL\Structure\{
	Field
};
use GraphQL\Type\Definition;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class FieldTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatMinimalStructureWorks()
	{
		$field = new Field(':name', ':description', Definition\Type::string());

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

(new FieldTest)->run();
