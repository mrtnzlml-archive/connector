<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Devices.DomainModel.WeatherStation.WeatherStationRecord.dcm.xml
 */
class WeatherStationRecord
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
	 * @var array
	 */
	private $data;

	public function __construct(WeatherStationRecordId $recordId, WeatherStationId $weatherStationId, array $recordData)
	{
		$this->id = $recordId;
		$this->weatherStationId = $weatherStationId;
		$this->data = $recordData;
	}

	public function id(): WeatherStationRecordId
	{
		return $this->id;
	}

	public function weatherStationId(): WeatherStationId
	{
		return $this->weatherStationId;
	}

	public function data(): array
	{
		return $this->data;
	}

}
