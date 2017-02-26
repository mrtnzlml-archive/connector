<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Common\DomainModel\Stub;

interface IAllWeatherStationRecords
{

	public function add(WeatherStationRecord $aWeatherStationRecord);

	public function withId(WeatherStation $weatherStation, WeatherStationRecordId $recordId): Stub;

	public function ofSingleWeatherStation(WeatherStation $weatherStation, \DateTimeImmutable $untilDate, int $recordsLimit = 1000, int $gap = 1): ?array;

	/**
	 * @param WeatherStation[] $weatherStations
	 * @return WeatherStationRecord[][] indexed by ID of weather station
	 */
	public function ofAllWeatherStations(array $weatherStations, \DateTimeImmutable $untilDate, int $limitForEachStation = 1000, int $gap = 1): array;

	public function nextIdentity(): WeatherStationRecordId;

}
