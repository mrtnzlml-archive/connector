<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Devices\Application\Service\WeatherStation\CountAllWeatherStations;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;
use Adeira\Connector\GraphQL\Context;

final class WeatherStationsConnection
{

	/**
	 * @var \Adeira\Connector\Devices\Application\Service\WeatherStation\CountAllWeatherStations
	 */
	private $countAllWeatherStations;

	public function __construct(CountAllWeatherStations $countAllWeatherStations)
	{
		$this->countAllWeatherStations = $countAllWeatherStations;
	}

	/**
	 * @param WeatherStation[] $ws
	 * @return WeatherStation[]
	 */
	public function edges(array $ws, array $args, Context $context): array
	{
		return $ws; // fall through
	}

	/**
	 * @param WeatherStation[] $ws
	 * @return int
	 */
	public function totalCount(array $ws, array $args, Context $context): int
	{
		return $this->countAllWeatherStations->execute($context->userId());
	}

	/**
	 * @param WeatherStation[] $ws
	 * @return WeatherStation[]
	 */
	public function weatherStations(array $ws, array $args, Context $context): array
	{
		return $ws; // fall through
	}

}
