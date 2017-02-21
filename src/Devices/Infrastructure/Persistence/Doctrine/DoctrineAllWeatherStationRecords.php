<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Common\DomainModel\Stub;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IAllWeatherStationRecords, WeatherStation, WeatherStationRecord, WeatherStationRecordId
};
use Doctrine\ORM;

final class DoctrineAllWeatherStationRecords implements IAllWeatherStationRecords
{

	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	public function __construct(ORM\EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function add(WeatherStationRecord $aWeatherStationRecord)
	{
		$this->em->persist($aWeatherStationRecord);
	}

	public function withId(WeatherStation $weatherStation, WeatherStationRecordId $recordId): Stub
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select($dqlAlis = 'wsr')->from(WeatherStationRecord::class, $dqlAlis);
		$qb->where("$dqlAlis.id = :recordId")->setParameter(':recordId', $recordId);
		$qb->andWhere("$dqlAlis.weatherStationId = :stationId")->setParameter(':stationId', (string)$weatherStation->id());
		return Stub::wrap($qb);
	}

	public function ofWeatherStation(WeatherStation $weatherStation, int $recordsLimit = 1000): Stub
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select($dqlAlias = 'wsr')->from(WeatherStationRecord::class, $dqlAlias);
		$qb->where("$dqlAlias.weatherStationId = :stationId")->setParameter(':stationId', (string)$weatherStation->id());
		$qb->setMaxResults($recordsLimit);
		return Stub::wrap($qb);
	}

	/**
	 * Returns limited number of records for each weather station.
	 * Output format is array indexed by weather station ID with array of records (limited).
	 *
	 * Alternative (but slower) approach is:
	 *
	 * SELECT *
	 * FROM weather_stations
	 * JOIN (
	 *   SELECT row_number() OVER(PARTITION BY weather_station_id ORDER BY id) AS rowNo, *
	 *   FROM weather_stations_records
	 * ) t ON weather_stations.id = t.weather_station_id
	 * WHERE weather_stations.id IN ('00000000-0001-0000-0000-000000000001', '00000000-0001-0000-0000-000000000002')
	 *   AND (t.rowNo % 2) = 0
	 *   AND t.rowNo <= 10;
	 */
	public function ofAllWeatherStations(array $weatherStations, int $limitForEach = 1000): array
	{
		/** @var WeatherStation[] $weatherStations */
		$weatherStations = (function (WeatherStation ...$weatherStations) {
			return $weatherStations;
		})(...$weatherStations);

		$weatherStationIds = [];
		foreach ($weatherStations as $weatherStation) {
			$weatherStationIds[] = (string)$weatherStation->id();
		}

		$rsmBuilder = new \Doctrine\ORM\Query\ResultSetMappingBuilder($this->em);
		$rsmBuilder->addRootEntityFromClassMetadata(WeatherStationRecord::class, 'wsr');

		$sql = <<<SQL
-- select X rows for each weather station:
SELECT {$rsmBuilder->generateSelectClause()}
FROM weather_stations
INNER JOIN LATERAL (
  -- select every 2nd filtered row for weather station (a little gap):
  SELECT indexedRecords.*
  FROM (
    -- select every row related to the weather_station_id (with window sequential rowNo):
    SELECT row_number() OVER() AS rowNo, *
    FROM weather_stations_records
    WHERE weather_station_id = weather_stations.id
    ORDER BY creation_date DESC
    LIMIT :initialSelectLimit
  ) indexedRecords
  WHERE (indexedRecords.rowNo % :gapSize = 0)
  LIMIT :recordsPerStation
) wsr ON TRUE
WHERE weather_stations.id IN (:weatherStationIds);
SQL;

		$gapSize = 1; //FIXME: configurable (internal calculation only? - probably not)

		$query = $this->em->createNativeQuery($sql, $rsmBuilder);
		$query->setParameter(':recordsPerStation', $limitForEach);
		$query->setParameter(':gapSize', $gapSize);
		$query->setParameter(':initialSelectLimit', $limitForEach * $gapSize); // always must be (recordsPerStation * gapSize)
		$query->setParameter(':weatherStationIds', $weatherStationIds);

		$result = [];
		/** @var WeatherStationRecord $record */
		foreach ($query->getResult() as $record) {
			$result[(string)$record->weatherStationId()][] = $record;
		}

		return $result;
	}

	public function nextIdentity(): WeatherStationRecordId
	{
		return WeatherStationRecordId::create();
	}

}
