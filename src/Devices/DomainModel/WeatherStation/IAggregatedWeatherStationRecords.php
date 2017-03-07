<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

interface IAggregatedWeatherStationRecords
{

	public function ofSingleWeatherStation(
		WeatherStation $weatherStation,
		\DateTimeImmutable $untilDate,
		int $recordsLimit,
		RecordAggregationRange $aggregationRange
	): ?array;

}
