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

	public function ofWeatherStation(WeatherStation $weatherStation): Stub
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select($dqlAlias = 'wsr')->from(WeatherStationRecord::class, $dqlAlias);
		$qb->where("$dqlAlias.weatherStationId = :stationId")->setParameter(':stationId', (string)$weatherStation->id());
		return Stub::wrap($qb);
	}

	public function ofAllWeatherStations(array $weatherStations): array
	{
		/** @var WeatherStation[] $weatherStations */
		$weatherStations = (function (WeatherStation ...$weatherStations) {
			return $weatherStations;
		})(...$weatherStations);

		$weatherStationIds = [];
		foreach ($weatherStations as $weatherStation) {
			$weatherStationIds[] = (string)$weatherStation->id();
		}

		$qb = $this->em->createQueryBuilder();
		$qb->select($dqlAlias = 'wsr')->from(WeatherStationRecord::class, $dqlAlias);
		$qb->where($qb->expr()->in('wsr.weatherStationId', $weatherStationIds));

		$result = [];
		/** @var WeatherStationRecord $record */
		foreach ($qb->getQuery()->getResult() as $record) {
			$result[(string)$record->weatherStationId()][] = $record;
		}

		return $result;
	}

	public function nextIdentity(): WeatherStationRecordId
	{
		return WeatherStationRecordId::create();
	}

}
