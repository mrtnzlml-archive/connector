<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Infrastructure\DI\Nette;

use Tester\Assert;

require getenv('BOOTSTRAP');
require __DIR__ . '/ContainerBuilder.php';

/**
 * @testCase
 */
final class ExtensionEnumTest extends \Adeira\Connector\Tests\TestCase
{

	public function testEnums()
	{
		$container = ContainerBuilder::createContainer(__DIR__ . '/config/enums.neon');
		Assert::same(
			['graphql.enum.EnumName1', 'graphql.enum.EnumName2'],
			$container->findByType(\GraphQL\Type\Definition\EnumType::class)
		);

		/** @var \GraphQL\Type\Definition\EnumType $enumType */
		$enumType = $container->getService('graphql.enum.EnumName1');
		Assert::type(\GraphQL\Type\Definition\EnumType::class, $enumType);
		Assert::same([
			['value' => 'value11', 'name' => 'key11'],
			['value' => 'value12', 'name' => 'key12'],
		], array_map(function (\GraphQL\Type\Definition\EnumValueDefinition $item) {
			return [
				'value' => $item->value,
				'name' => $item->name,
			];
		}, $enumType->getValues()));
	}

}

(new ExtensionEnumTest)->run();
