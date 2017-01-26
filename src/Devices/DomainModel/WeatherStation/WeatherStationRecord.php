<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

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
	 * @var Pressure
	 */
	private $pressure;

	public function __construct(WeatherStationRecordId $recordId, WeatherStationId $weatherStationId, Pressure $pressure)
	{
		$this->id = $recordId;
		$this->weatherStationId = $weatherStationId;
		$this->pressure = $pressure;
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
		return $this->pressure;
	}

}
