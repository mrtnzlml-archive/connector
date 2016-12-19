<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;
use GraphQL\Type\Definition;

class WeatherStationType implements \Adeira\Connector\GraphQL\IType
{

	/**
	 * type Device_1 : WeatherStation {
	 *     id: String!
	 * }
	 *
	 * @throws \Exception
	 */
	public function __invoke(): Definition\ObjectType
	{
		return new Definition\ObjectType([
			'name' => 'WeatherStation',
			'description' => 'An inbound data source.',
			'fields' => [
				'id' => [
					'type' => new Definition\NonNull(
						Definition\Type::string()
					),
					'description' => 'The ID of the data source.',
					'resolve' => function (WeatherStation $obj, $args, $context) {
						return $obj->id();
					},
				],
				'name' => [
					'type' => new Definition\NonNull(
						Definition\Type::string()
					),
					'description' => 'Name of the data source.',
					'resolve' => function (WeatherStation $obj, $args, $context) {
						return $obj->deviceName();
					},
				],
				'records' => [
					'type' => Definition\Type::listOf(
						Definition\Type::string() //FIXME: WeatherStationsRecordTypes
					),
					'description' => 'Records of the data source.',
					'args' => [
						'first' => [ // length from beginning
							'type' => Definition\Type::int(),
							'defaultValue' => 1000,
						],
					],
					'resolve' => function (WeatherStation $obj, $args, $context) {
						$data = ['abc', 'xyz']; //TODO: records (record ID + data)
						return array_slice($data, 0, $args['first']);
					},
				],
			],
		]);
	}

}
