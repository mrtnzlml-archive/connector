<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Common\Infrastructure\DomainModel\Doctrine\Specification\ISpecification;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IWeatherStationRepository, WeatherStation, WeatherStationId
};

final class InMemoryWeatherStationRepository /*extends ORM\EntityRepository*/ implements IWeatherStationRepository
{

	private $memory;

	private $weatherStationId;

	public function __construct(?WeatherStationId $weatherStationId = NULL)
	{
		$this->memory = new \Doctrine\Common\Collections\ArrayCollection;
		$this->weatherStationId = $weatherStationId;
	}

	public function add(WeatherStation $aWeatherStation)
	{
		$this->memory->set((string)$aWeatherStation->id(), $aWeatherStation);
	}

	public function ofId(WeatherStationId $weatherStationId): ?WeatherStation
	{
		return $this->memory->get((string)$weatherStationId);
	}

	public function countBySpecification(ISpecification $specification): int
	{
		throw new \Nette\NotImplementedException;
	}

	public function findBySpecification(ISpecification $specification): array
	{
		throw new \Nette\NotImplementedException;
	}

	public function nextIdentity(): WeatherStationId
	{
		return $this->weatherStationId ?? WeatherStationId::create();
	}

}
