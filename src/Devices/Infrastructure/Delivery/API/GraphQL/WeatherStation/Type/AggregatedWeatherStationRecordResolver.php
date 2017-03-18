<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStation\Type;

use Adeira\Connector\Devices\DomainModel\WeatherStation\AggregatedWeatherStationRecord as AggRecord;

final class AggregatedWeatherStationRecordResolver
{

	public function aggregatedDate(AggRecord $wsr): \DateTimeImmutable
	{
		return $wsr->aggregatedDate();
	}

	public function absolutePressure(AggRecord $wsr, array $args): ?float
	{
		return $wsr->pressure()->absolute($args['pressureUnit']);
	}

	public function relativePressure(AggRecord $wsr, array $args): ?float
	{
		return $wsr->pressure()->relative($args['pressureUnit']);
	}

	public function indoorTemperature(AggRecord $wsr, array $args): ?float
	{
		return $wsr->temperature()->indoor($args['temperatureUnit']);
	}

	public function outdoorTemperature(AggRecord $wsr, array $args): ?float
	{
		return $wsr->temperature()->outdoor($args['temperatureUnit']);
	}

	public function indoorHumidity(AggRecord $wsr, array $args): ?float
	{
		return $wsr->humidity()->indoor($args['humidityUnit']);
	}

	public function outdoorHumidity(AggRecord $wsr, array $args): ?float
	{
		return $wsr->humidity()->outdoor($args['humidityUnit']);
	}

	public function windSpeed(AggRecord $wsr, array $args): ?float
	{
		return $wsr->wind()->speed($args['windSpeedUnit']);
	}

	public function windAzimuth(AggRecord $wsr): ?float
	{
		return $wsr->wind()->directionAzimuth();
	}

	public function windGust(AggRecord $wsr, array $args): ?float
	{
		return $wsr->wind()->gust($args['windSpeedUnit']);
	}

}
