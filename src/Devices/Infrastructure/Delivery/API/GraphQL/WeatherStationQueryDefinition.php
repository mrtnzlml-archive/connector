<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\Application\Service\WeatherStation\{
	ViewAllWeatherStationsService, ViewSingleWeatherStationService
};
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\GraphQL\Structure\{
	Argument, Field
};
use GraphQL\Type\Definition;

class WeatherStationQueryDefinition implements \Adeira\Connector\GraphQL\IQueryDefinition
{

	/**
	 * @var ViewAllWeatherStationsService
	 */
	private $allWeatherStationsService;

	/**
	 * @var ViewSingleWeatherStationService
	 */
	private $singleWeatherStationService;

	/**
	 * @var \Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStationType
	 */
	private $weatherStationType;

	/**
	 * @var \Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStationsConnection
	 */
	private $weatherStationsConnection;

	public function __construct(
		ViewAllWeatherStationsService $allWeatherStationsService,
		ViewSingleWeatherStationService $singleWeatherStationService,
		WeatherStationType $weatherStationType,
		WeatherStationsConnection $weatherStationsConnection
	) {
		$this->allWeatherStationsService = $allWeatherStationsService;
		$this->singleWeatherStationService = $singleWeatherStationService;
		$this->weatherStationType = $weatherStationType;
		$this->weatherStationsConnection = $weatherStationsConnection;
	}

	public function __invoke(): array
	{
		$weatherStationType = $this->weatherStationType;
		return [
			'weatherStation' => Field::create(
				$weatherStationType,
				function ($ancestorValue, $args, UserId $userId) {
					return $this->singleWeatherStationService->execute(
						$userId,
						WeatherStationId::createFromString($args['id'])
					);
				},
				[
					'id' => Argument::create(Definition\Type::nonNull(
						Definition\Type::string()
					), 'The ID of the weather station.'),
				]
			),
			'allWeatherStations' => Field::create(
				$this->weatherStationsConnection,
				function ($ancestorValue, $args, UserId $userId) {
					$limit = $args['first'] ?? NULL;
					$fromWeatherStationId = isset($args['after']) ? WeatherStationId::createFromString(base64_decode($args['after'])) : NULL;
					return $this->allWeatherStationsService->execute($userId, $limit, $fromWeatherStationId);
				},
				[
					'first' => Argument::create(
						Definition\Type::int()
					),
					'after' => Argument::create(
						Definition\Type::string()
					),
				]
			),
		];
	}

}
