<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStation\Query;

use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewSingleWeatherStation;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\GraphQL\Context;

final class WeatherStationResolver
{

	/**
	 * @var ViewSingleWeatherStation
	 */
	private $singleWeatherStationService;

	public function __construct(ViewSingleWeatherStation $singleWeatherStationService)
	{
		$this->singleWeatherStationService = $singleWeatherStationService;
	}

	public function __invoke($ancestorValue, $args, Context $context)
	{
		return $this->singleWeatherStationService->execute(
			$context->userId(),
			WeatherStationId::createFromString($args['id'])
		);
	}

}
