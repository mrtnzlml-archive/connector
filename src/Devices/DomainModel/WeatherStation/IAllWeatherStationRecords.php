<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Common\DomainModel\Stub;

interface IAllWeatherStationRecords
{

	public function add(WeatherStationRecord $aWeatherStationRecord);

	public function withId(Owner $owner, WeatherStationRecordId $recordId): Stub; //TODO: owner!

	public function ofWeatherStationId(WeatherStationId $weatherStationId): array; //TODO: owner!

	public function ofAllWeatherStationIds(array $weatherStationId): array; //TODO: owner!

	public function nextIdentity(): WeatherStationRecordId;

}
