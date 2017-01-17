<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\GraphQL\Structure\Field;
use GraphQL\Type\Definition;

class WeatherStationsConnection extends Definition\ObjectType
{

	public function __construct(WeatherStationType $wst, WeatherStationsEdge $wsEdge)
	{
		parent::__construct([
			'name' => 'WeatherStationsConnection',
			'description' => 'Connection to the weather stations',
			'fields' => [
				//TODO: pageInfo:(hasNextPage, hasPreviousPage, startCursor, endCursor)

				'edges' => Field::create(
					Definition\Type::listOf($wsEdge),
					function (array $weatherStations, $args, UserId $userId) {
						return $weatherStations; //FIXME: is this needed?
					}
				),
				'totalCount' => Field::create(
					Definition\Type::nonNull(Definition\Type::int()),
					function (array $weatherStations, $args, UserId $userId) {
						return count($weatherStations); //FIXME: doesn't work with subselection!
					}
				),
				'weatherStations' => Field::create(
					Definition\Type::listOf($wst),
					function (array $weatherStations, $args, UserId $userId) {
						return $weatherStations; //FIXME: is this needed?
					}
				),
			],
		]);
	}

}
