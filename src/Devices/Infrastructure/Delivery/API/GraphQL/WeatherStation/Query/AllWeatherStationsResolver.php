<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStation\Query;

use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewAllWeatherStations;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;

final class AllWeatherStationsResolver
{

	/**
	 * @var ViewAllWeatherStations
	 */
	private $allWeatherStationsService;

	public function __construct(ViewAllWeatherStations $allWeatherStationsService)
	{
		$this->allWeatherStationsService = $allWeatherStationsService;
	}

	/**
	 * @return \Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation[]
	 */
	public function __invoke($ancestorValue, $args, \Adeira\Connector\GraphQL\Context $context)
	{
		$limit = $args['first'] ?? NULL;
		$fromWeatherStationId = isset($args['after']) ? WeatherStationId::createFromString(base64_decode($args['after'])) : NULL;
		return $this->allWeatherStationsService->execute($context->userId(), $limit, $fromWeatherStationId);
	}

}
