<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Devices\DomainModel\PhysicalQuantities;
use Adeira\Connector\Devices\DomainModel\Pressure;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Devices.DomainModel.WeatherStation.WeatherStationRecord.dcm.xml
 */
final class WeatherStationRecord
{

	/**
	 * @var WeatherStationRecordId
	 */
	private $id;

	/**
	 * @var WeatherStationId
	 */
	private $weatherStationId;

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\PhysicalQuantities
	 */
	private $physicalQuantities;

	public function __construct(WeatherStationRecordId $recordId, WeatherStationId $weatherStationId, PhysicalQuantities $quantities)
	{
		$this->id = $recordId;
		$this->weatherStationId = $weatherStationId;
		$this->physicalQuantities = $quantities;
	}

	public function id(): WeatherStationRecordId
	{
		return $this->id;
	}

	public function weatherStationId(): WeatherStationId
	{
		return $this->weatherStationId;
	}

	public function pressure(): Pressure
	{
		return $this->physicalQuantities->pressure();
	}

	public function temperature()
	{
		return $this->physicalQuantities->temperature();
	}

}
