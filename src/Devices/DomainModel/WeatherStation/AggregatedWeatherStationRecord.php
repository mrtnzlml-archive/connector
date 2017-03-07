<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Devices\DomainModel\{
	Humidity,
	PhysicalQuantities,
	Pressure,
	Temperature,
	Wind
};

/**
 * This is aggregated version of WS record (hour, day, week, month). Therefore it doesn't have ID because it's average of time period.
 */
final class AggregatedWeatherStationRecord
{

	/**
	 * @var WeatherStationId
	 */
	private $weatherStationId;

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\PhysicalQuantities
	 */
	private $physicalQuantities;

	/**
	 * @var \DateTimeImmutable
	 */
	private $aggregatedDate;

	public function __construct(
		WeatherStationId $weatherStationId,
		PhysicalQuantities $quantities,
		\DateTimeImmutable $aggregatedDate
	) {
		$this->weatherStationId = $weatherStationId;
		$this->physicalQuantities = $quantities;
		$this->aggregatedDate = $aggregatedDate;
	}

	public function weatherStationId(): WeatherStationId
	{
		return $this->weatherStationId;
	}

	public function pressure(): Pressure
	{
		return $this->physicalQuantities->pressure();
	}

	public function temperature(): Temperature
	{
		return $this->physicalQuantities->temperature();
	}

	public function humidity(): Humidity
	{
		return $this->physicalQuantities->humidity();
	}

	public function wind(): Wind
	{
		return $this->physicalQuantities->wind();
	}

	public function aggregatedDate(): \DateTimeImmutable
	{
		if ($this->aggregatedDate instanceof \DateTime) {
			return \DateTimeImmutable::createFromMutable($this->aggregatedDate);
		}
		return $this->aggregatedDate;
	}

}
