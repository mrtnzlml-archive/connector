<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Type;

use Adeira\Connector\GraphQL\Type\InputValue;
use function Adeira\Connector\GraphQL\string;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class InputValueTest extends \Adeira\Connector\Tests\TestCase
{

	public function testStructure()
	{
		$structure = (new InputValue('Name', string()))->buildStructure();
		Assert::equal([
			'name' => 'Name',
			'type' => string(),
			'defaultValue' => NULL,
			'description' => NULL,
		], $structure);
	}

}

(new InputValueTest)->run();
