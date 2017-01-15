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

	public function __construct(
		ViewAllWeatherStationsService $allWeatherStationsService,
		ViewSingleWeatherStationService $singleWeatherStationService,
		WeatherStationType $weatherStationType
	) {
		$this->allWeatherStationsService = $allWeatherStationsService;
		$this->singleWeatherStationService = $singleWeatherStationService;
		$this->weatherStationType = $weatherStationType;
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
			'weatherStations' => Field::create(
				Definition\Type::listOf($weatherStationType),
				function ($ancestorValue, $args, UserId $userId) {
					return $this->allWeatherStationsService->execute($userId);
				}
			),
		];
	}

}
