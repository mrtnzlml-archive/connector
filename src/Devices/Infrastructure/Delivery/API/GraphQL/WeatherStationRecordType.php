<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecord;
use Adeira\Connector\GraphQL\Structure\Field;
use GraphQL\Type\Definition;

class WeatherStationRecordType extends Definition\ObjectType
{

	public function __construct()
	{
		parent::__construct([
			'name' => 'WeatherStationRecord',
			'description' => 'Record of weather station.',
			'fields' => [
				'id' => Field::create(
					new Definition\NonNull(
						Definition\Type::string()
					),
					function (WeatherStationRecord $wsr, $args, UserId $userId) {
						return $wsr->id();
					},
					NULL,
					'ID of the weather station record.'
				),
			],
		]);
	}

}
