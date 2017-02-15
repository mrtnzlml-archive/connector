<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL;

use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class TypesTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatMinimalStructureWorks()
	{
		$definedFunctions = [];
		foreach (get_defined_functions()['user'] as $functionName) {
			$needle = 'adeira\\connector\\graphql\\';
			if (self::startsWith($functionName, $needle)) {
				$definedFunctions[] = str_replace($needle, '', $functionName);
			}
		}
		Assert::same([
			'id',
			'int',
			'float',
			'string',
			'nullableint',
			'nullablefloat',
			'nullablestring',
			'required',
			'listof',
			'type',
		], $definedFunctions);
	}

	private static function startsWith($haystack, $needle)
	{
		return strncmp($haystack, $needle, strlen($needle)) === 0;
	}

}

(new TypesTest)->run();
