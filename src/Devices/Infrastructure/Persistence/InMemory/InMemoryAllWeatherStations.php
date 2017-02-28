<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\InMemory;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Common\DomainModel\Stub;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IAllWeatherStations, WeatherStation, WeatherStationId
};

final class InMemoryAllWeatherStations implements IAllWeatherStations
{

	private $memory;

	private $weatherStationId;

	public function __construct(?WeatherStationId $weatherStationId = NULL)
	{
		$this->memory = new \Doctrine\Common\Collections\ArrayCollection;
		$this->weatherStationId = $weatherStationId;
	}

	public function add(WeatherStation $aWeatherStation): void
	{
		$this->memory->set((string)$aWeatherStation->id(), $aWeatherStation);
	}

	public function remove(WeatherStation $aWeatherStation): void
	{
		$this->memory->remove((string)$aWeatherStation->id());
	}

	public function withId(Owner $owner, WeatherStationId $weatherStationId): Stub
	{
		/** @var WeatherStation $weatherStation */
		$weatherStation = $this->memory->get((string)$weatherStationId);
		if ($weatherStation && $owner->id()->equals($weatherStation->ownerId())) {
			return Stub::wrap([$weatherStation]);
		}
		return Stub::wrap(NULL);
	}

	public function belongingTo(Owner $owner): Stub
	{
		$stations = [];
		/** @var WeatherStation $weatherStation */
		foreach ($this->memory as $weatherStation) {
			if ($weatherStation->ownerId()->equals($owner->id())) {
				$stations[] = $weatherStation;
			}
		}
		return Stub::wrap($stations);
	}

	public function nextIdentity(): WeatherStationId
	{
		return $this->weatherStationId ?? WeatherStationId::create();
	}

}
