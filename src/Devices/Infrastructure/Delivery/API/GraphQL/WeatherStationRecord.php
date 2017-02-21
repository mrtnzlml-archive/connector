<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecord as Record;

final class WeatherStationRecord
{

	public function id(Record $wsr)
	{
		return $wsr->id();
	}

	public function absolutePressure(Record $wsr, array $args): ?float
	{
		return $wsr->pressure()->absolute($args['pressureUnit']);
	}

	public function relativePressure(Record $wsr, array $args): ?float
	{
		return $wsr->pressure()->relative($args['pressureUnit']);
	}

	public function indoorTemperature(Record $wsr, array $args): ?float
	{
		return $wsr->temperature()->indoor($args['temperatureUnit']);
	}

	public function outdoorTemperature(Record $wsr, array $args): ?float
	{
		return $wsr->temperature()->outdoor($args['temperatureUnit']);
	}

	public function indoorHumidity(Record $wsr, array $args): ?float
	{
		return $wsr->humidity()->indoor($args['humidityUnit']);
	}

	public function outdoorHumidity(Record $wsr, array $args): ?float
	{
		return $wsr->humidity()->outdoor($args['humidityUnit']);
	}

	public function windSpeed(Record $wsr, array $args): ?float
	{
		return $wsr->wind()->speed($args['windSpeedUnit']);
	}

	public function windAzimuth(Record $wsr): ?float
	{
		return $wsr->wind()->directionAzimuth();
	}

	public function windGust(Record $wsr, array $args): ?float
	{
		return $wsr->wind()->gust($args['windSpeedUnit']);
	}

}
