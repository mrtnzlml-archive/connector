<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Devices.DomainModel.WeatherStation.WeatherStationSeries.dcm.xml
 */
final class WeatherStationSeries
{

	/**
	 * @var WeatherStationSeriesId
	 */
	private $id;

	/**
	 * Code of the weather station series.
	 * @var string
	 */
	private $code;

	public function __construct(WeatherStationSeriesId $recordId, string $seriesCode)
	{
		$this->id = $recordId;
		$this->code = $seriesCode;
	}

	public function id(): WeatherStationSeriesId
	{
		return $this->id;
	}

	public function code()
	{
		return $this->code;
	}

}
