<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Exceptions\WeatherStation;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;

final class WeatherStationDoesNotExistException extends \Exception
{

	public function __construct(WeatherStationId $weatherStationId)
	{
		parent::__construct("Weather station with ID $weatherStationId does not exist.");
	}

}
