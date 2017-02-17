<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Infrastructure\DI\Nette;

use Tester\Assert;

require getenv('BOOTSTRAP');
require __DIR__ . '/ContainerBuilder.php';

/**
 * @testCase
 */
final class ExtensionInputTypesTest extends \Adeira\Connector\Tests\TestCase
{

	public function testInputTypes()
	{
		$container = ContainerBuilder::createContainer(__DIR__ . '/config/inputTypes.neon');
		/** @var \GraphQL\Type\Definition\InputObjectType $inputType */
		$inputType = $container->getService('graphql.inputType.PhysicalQuantitiesInput');
		Assert::equal([
			'name' => 'PhysicalQuantitiesInput',
			'fields' => [
				'absolutePressure' => [
					'type' => new \GraphQL\Type\Definition\FloatType,
					'defaultValue' => NULL,
				],
				'relativePressure' => [
					'type' => new \GraphQL\Type\Definition\FloatType,
					'defaultValue' => 1.0,
				],
				'pressureUnit' => [
					'type' => new \GraphQL\Type\Definition\EnumType([
						'values' => [
							[
								'name' => 'BAR',
								'value' => 'BarValue',
								'deprecationReason' => NULL,
								'description' => NULL,
							],
							[
								'name' => 'PASCAL',
								'value' => 'PascalValue',
								'deprecationReason' => NULL,
								'description' => NULL,
							],
						],
						'valueLookup' => NULL,
						'nameLookup' => NULL,
						'name' => 'PressureUnit',
						'description' => NULL,
					]),
					'defaultValue' => 'PascalValue',
				],
			],
		], $inputType->config);
	}

}

(new ExtensionInputTypesTest)->run();
