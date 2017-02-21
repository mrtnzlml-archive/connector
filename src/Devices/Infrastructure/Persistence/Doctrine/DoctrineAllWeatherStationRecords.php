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
SELECT {$rsmBuilder->generateSelectClause()}
FROM weather_stations 
INNER JOIN LATERAL (
    SELECT * FROM weather_stations_records 
    WHERE weather_station_id = weather_stations.id 
    LIMIT :limitForEach
) wsr ON TRUE
WHERE weather_stations.id IN (:weatherStationIds)
SQL;

		$query = $this->em->createNativeQuery($sql, $rsmBuilder);
		$query->setParameter(':weatherStationIds', $weatherStationIds);
		$query->setParameter(':limitForEach', $limitForEach);

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
