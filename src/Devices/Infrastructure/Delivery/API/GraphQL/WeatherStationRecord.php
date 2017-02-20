<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecord as Record;

final class WeatherStationRecord
{

	public function id(Record $wsr)
	{
		return $wsr->id();
	}

	public function absolutePressure(Record $wsr): ?float
	{
		return $wsr->pressure()->absolute();
	}

	public function relativePressure(Record $wsr): ?float
	{
		return $wsr->pressure()->relative();
	}

	public function indoorTemperature(Record $wsr): ?float
	{
		return $wsr->temperature()->indoor();
	}

	public function outdoorTemperature(Record $wsr): ?float
	{
		return $wsr->temperature()->outdoor();
	}

	public function indoorHumidity(Record $wsr): ?float
	{
		return $wsr->humidity()->indoor();
	}

	public function outdoorHumidity(Record $wsr): ?float
	{
		return $wsr->humidity()->indoor();
	}

}
