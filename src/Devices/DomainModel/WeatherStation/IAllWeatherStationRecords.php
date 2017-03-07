<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Common\DomainModel\Stub;

interface IAllWeatherStationRecords
{

	public function add(WeatherStationRecord $aWeatherStationRecord);

	public function purgeWeatherStation(WeatherStation $aStation);

	public function withId(WeatherStation $weatherStation, WeatherStationRecordId $recordId): Stub;

	public function totalCount(WeatherStationId $weatherStationId): int;

	public function nextIdentity(): WeatherStationRecordId;

}
