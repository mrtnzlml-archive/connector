<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Common\Infrastructure\DomainModel\Doctrine\Specification\ISpecification;

interface IWeatherStationRepository
{

	public function add(WeatherStation $aWeatherStation);

//	public function addAll(array $weatherStations);

	public function ofId(WeatherStationId $weatherStationId): ?WeatherStation;

	public function countBySpecification(ISpecification $specification): int;

	public function findBySpecification(ISpecification $specification): array;

	//TODO: findOneBySpecification

//	public function remove(WeatherStation $aWeatherStation);

//	public function removeAll(array $weatherStations);

	public function nextIdentity(): WeatherStationId;

}
