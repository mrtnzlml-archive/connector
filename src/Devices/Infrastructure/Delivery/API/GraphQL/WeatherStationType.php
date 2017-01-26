<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewAllWeatherStationRecordsService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;
use Adeira\Connector\GraphQL\Structure\Field;
use GraphQL\Type\Definition;

final class WeatherStationType extends Definition\ObjectType
{

	public function __construct(WeatherStationRecordType $wsrt, ViewAllWeatherStationRecordsService $allWsRecords)
	{
		parent::__construct([
			'name' => 'WeatherStation',
			'description' => 'Weather station',
			'fields' => [
				'id' => Field::create(
					new Definition\NonNull(
						Definition\Type::string()
					),
					function (WeatherStation $ws, $args, UserId $userId) {
						return $ws->id();
					},
					NULL,
					'ID of the weather station'
				),
				'name' => Field::create(
					new Definition\NonNull(
						Definition\Type::string()
					),
					function (WeatherStation $obj, $args, UserId $userId) {
						return $obj->deviceName();
					},
					NULL,
					'Name of the weather station'
				),
				'records' => [
					'type' => Definition\Type::listOf($wsrt),
					'description' => 'Records of the weather station',
					'resolve' => function (WeatherStation $ws, $args, UserId $userId) use ($allWsRecords) {
						return $allWsRecords->execute($userId, $ws->id());
					},
				],
			],
		]);
	}

}
