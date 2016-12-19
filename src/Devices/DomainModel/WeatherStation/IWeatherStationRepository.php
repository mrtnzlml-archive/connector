<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;

interface IWeatherStationRepository
{

	public function add(WeatherStation $aWeatherStation);

//	public function addAll(array $weatherStations);

	public function ofId(WeatherStationId $weatherStationId);//: ?WeatherStation;

	public function all(UserId $userId);//: iterable;

//	public function remove(WeatherStation $aWeatherStation);

//	public function removeAll(array $weatherStations);

	public function nextIdentity(): WeatherStationId;

}
