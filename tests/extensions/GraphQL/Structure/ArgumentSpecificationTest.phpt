<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Structure;

use Adeira\Connector\GraphQL\Structure\{
	ArgumentSpecification
};
use GraphQL\Type\Definition;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class ArgumentSpecificationTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatMinimalStructureWorks()
	{
		$arg = new ArgumentSpecification(':name', ':description', Definition\Type::string());

		Assert::equal(
			[
				':name' => [
					'type' => Definition\Type::string(),
					'description' => ':description',
				],
			],
			$arg->buildArray()
		);
	}

}

(new ArgumentSpecificationTest)->run();
