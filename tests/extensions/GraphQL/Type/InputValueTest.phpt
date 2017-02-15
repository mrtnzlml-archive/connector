<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Type;

use Adeira\Connector\GraphQL\Type\InputValue;
use Tester\Assert;
use function Adeira\Connector\GraphQL\string;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class InputValueTest extends \Adeira\Connector\Tests\TestCase
{

	public function testStructure()
	{
		$structure = (new InputValue('Name', string()))->_buildStructure();
		Assert::equal([
			'name' => 'Name',
			'type' => string(),
			'defaultValue' => NULL,
			'description' => NULL,
		], $structure);
	}

}

(new InputValueTest)->run();
