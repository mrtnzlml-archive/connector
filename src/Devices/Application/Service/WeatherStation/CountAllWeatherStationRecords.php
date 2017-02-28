<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStationRecords;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;

final class CountAllWeatherStationRecords
{

	private $allRecords;

	public function __construct(IAllWeatherStationRecords $allRecords)
	{
		$this->allRecords = $allRecords;
	}

	public function execute(WeatherStationId $stationId)
	{
		return $this->allRecords->totalCount($stationId);
	}

}
