<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Common\DomainModel\Stub;

interface IAllWeatherStations
{

	public function add(WeatherStation $aWeatherStation): void;

	public function withId(Owner $owner, WeatherStationId $weatherStationId): Stub;

	public function belongingTo(Owner $owner): Stub;

	public function nextIdentity(): WeatherStationId;

}
