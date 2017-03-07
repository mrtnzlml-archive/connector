<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Devices\DomainModel\{
	Humidity, Pressure, Temperature, Wind
};
use Adeira\Connector\Devices\DomainModel\PhysicalQuantities;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	AggregatedWeatherStationRecord, IAggregatedWeatherStationRecords, RecordAggregationRange, WeatherStation, WeatherStationId
};
use Adeira\Connector\PhysicalUnits\DomainModel\Humidity\Units\Percentage;
use Adeira\Connector\PhysicalUnits\DomainModel\Pressure\Units\Pascal;
use Adeira\Connector\PhysicalUnits\DomainModel\Speed\Units\Kmh;
use Adeira\Connector\PhysicalUnits\DomainModel\Temperature\Units\Celsius;
use Doctrine\ORM;

final class DoctrineAggregatedWeatherStationRecords implements IAggregatedWeatherStationRecords
{

	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	public function __construct(ORM\EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function ofSingleWeatherStation(
		WeatherStation $weatherStation,
		\DateTimeImmutable $untilDate,
		int $recordsLimit,
		RecordAggregationRange $aggregationRange
	): ?array
	{
		$rsm = new ORM\Query\ResultSetMapping; //FIXME: DRY!
		$rsm->addScalarResult('day', 'aggregated_date');
		$rsm->addScalarResult('weather_station_id', 'weather_station_id');
		$rsm->addScalarResult('pressure_absolute', 'pressure_absolute');
		$rsm->addScalarResult('pressure_relative', 'pressure_relative');
		$rsm->addScalarResult('temperature_indoor', 'temperature_indoor');
		$rsm->addScalarResult('temperature_outdoor', 'temperature_outdoor');
		$rsm->addScalarResult('humidity_indoor', 'humidity_indoor');
		$rsm->addScalarResult('humidity_outdoor', 'humidity_outdoor');
		$rsm->addScalarResult('wind_speed', 'wind_speed');
		$rsm->addScalarResult('wind_azimuth', 'wind_azimuth');
		$rsm->addScalarResult('wind_gust', 'wind_gust');

		$sql = <<<SQL
SELECT date_trunc(:aggregationRange, creation_date) AS day,
 weather_station_id,
 avg(pressure_absolute) AS pressure_absolute,
 avg(pressure_relative) AS pressure_relative,
 avg(temperature_indoor) AS temperature_indoor,
 avg(temperature_outdoor) AS temperature_outdoor,
 avg(humidity_indoor) AS humidity_indoor,
 avg(humidity_outdoor) AS humidity_outdoor,
 avg(wind_speed) AS wind_speed,
 avg(wind_azimuth) AS wind_azimuth,
 avg(wind_gust) AS wind_gust
FROM weather_stations_records
WHERE weather_station_id = :weatherStationId AND creation_date <= :untilDate
GROUP BY day, weather_station_id
ORDER BY day DESC
LIMIT :recordsLimit
SQL;

		$query = $this->em->createNativeQuery($sql, $rsm);
		$query->setParameter(':aggregationRange', $aggregationRange->getValue());
		$query->setParameter(':untilDate', $untilDate);
		$query->setParameter(':weatherStationId', (string)$weatherStation->id());
		$query->setParameter(':recordsLimit', $recordsLimit);

		$aggregatedResult = [];
		foreach ($query->getArrayResult() as $arrayResult) {
			$aggregatedResult[] = new AggregatedWeatherStationRecord(
				WeatherStationId::createFromString($arrayResult['weather_station_id']),
				new PhysicalQuantities(
					new Pressure(new Pascal($arrayResult['pressure_absolute']), new Pascal($arrayResult['pressure_relative'])),
					new Temperature(new Celsius($arrayResult['temperature_indoor']), new Celsius($arrayResult['temperature_outdoor'])),
					new Humidity(new Percentage($arrayResult['humidity_indoor']), new Percentage($arrayResult['humidity_outdoor'])),
					new Wind(new Kmh($arrayResult['wind_speed']), (float)$arrayResult['wind_azimuth'], new Kmh($arrayResult['wind_gust']))
				),
				new \DateTimeImmutable($arrayResult['aggregated_date'])
			);
		}
		return $aggregatedResult ?: NULL;
	}

}
