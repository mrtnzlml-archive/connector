<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

interface IWeatherStationRecordRepository
{

	public function add(WeatherStationRecord $aWeatherStationRecord);

	public function ofId(WeatherStationRecordId $weatherStationRecordId);

	public function ofWeatherStationId(WeatherStationId $weatherStationId): array;

	public function nextIdentity(): WeatherStationRecordId;

}
