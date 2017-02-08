<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Devices\DomainModel\Pressure;
use Adeira\Connector\PhysicalUnits\Pressure\Units\IPressureUnit;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Devices.DomainModel.WeatherStation.WeatherStation.dcm.xml
 */
final class WeatherStation
{

	/**
	 * @var WeatherStationId
	 */
	private $id;

	/**
	 * @var string
	 */
	private $owner;

	/**
	 * @var string
	 */
	private $deviceName;

	public function __construct(WeatherStationId $id, Owner $owner, string $deviceName)
	{
		$this->id = $id;
		$this->owner = (string)$owner->id();
		$this->deviceName = $deviceName;
	}

	public function id(): WeatherStationId
	{
		return $this->id;
	}

	public function owner(): string
	{
		return $this->owner;
	}

	public function deviceName(): string
	{
		return $this->deviceName;
	}

	public function makeWeatherStationRecord(WeatherStationRecordId $weatherStationRecordId, IPressureUnit $pressureUnit): WeatherStationRecord
	{
		return new WeatherStationRecord(
			$weatherStationRecordId,
			$this->id,
			new Pressure($pressureUnit)
		);
	}

}
