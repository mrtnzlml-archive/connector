<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Structure;

use Adeira\Connector\GraphQL\Structure\{
	Argument
};
use GraphQL\Type\Definition;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class ArgumentTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatMinimalStructureWorks()
	{
		$arg = new Argument(':name', ':description', Definition\Type::string());

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

(new ArgumentTest)->run();
