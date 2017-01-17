<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;
use Adeira\Connector\GraphQL\Structure\Field;
use GraphQL\Type\Definition;

class WeatherStationsEdge extends Definition\ObjectType
{

	public function __construct(WeatherStationType $wsType)
	{
		parent::__construct([
			'name' => 'WeatherStationsEdge',
			'description' => 'An edge in the weather stations connection',
			'fields' => [
				'cursor' => Field::create(
					new Definition\NonNull(
						Definition\Type::string()
					),
					function (WeatherStation $weatherStation) {
						return base64_encode((string)$weatherStation->id());
					}
				),
				'node' => Field::create(
					$wsType,
					function (WeatherStation $weatherStation) {
						return $weatherStation;
					}
				),
			],
		]);
	}

}
