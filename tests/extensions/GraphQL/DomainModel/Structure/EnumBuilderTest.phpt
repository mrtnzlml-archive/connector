<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\DomainModel\Structure;

use Adeira\Connector\GraphQL\DomainModel\Structure\EnumBuilder;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class EnumBuilderTest extends \Adeira\Connector\Tests\TestCase
{

	public function testBuildEnumArrayStructure()
	{
		$result = EnumBuilder::buildEnumArrayStructure('EnumName', []);
		Assert::same([
			'config' => [
				'name' => 'EnumName',
				'values' => [],
			],
		], $result);
	}

	public function testBuildEnumValues()
	{
		$result = EnumBuilder::buildEnumValues([
			'ATM' => 'Value\AtmClass',
			'PASCAL' => 'Value\PascalClass',
		]);
		Assert::same([
			'ATM' => [
				'value' => 'Value\AtmClass',
			],
			'PASCAL' => [
				'value' => 'Value\PascalClass',
			],
		], $result);
	}

}

(new EnumBuilderTest)->run();
