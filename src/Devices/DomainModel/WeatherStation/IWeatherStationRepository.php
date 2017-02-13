<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Common\Infrastructure\DomainModel\Doctrine\Specification\ISpecification;

//TODO: všechny dotazy musí být navázány na uživatelské ID!
interface IWeatherStationRepository
{

	public function add(WeatherStation $aWeatherStation);

//	public function addAll(array $weatherStations);

	public function ofId(WeatherStationId $weatherStationId, Owner $owner): ?WeatherStation;

	public function countBySpecification(ISpecification $specification): int; //FIXME: nešlo by to udělat ve specifikaci?

	public function findBySpecification(ISpecification $specification): array; //FIXME: specifikace co nejsou navázané na Doctrine!

	//TODO: findOneBySpecification

//	public function remove(WeatherStation $aWeatherStation);

//	public function removeAll(array $weatherStations);

	public function nextIdentity(): WeatherStationId;

}
