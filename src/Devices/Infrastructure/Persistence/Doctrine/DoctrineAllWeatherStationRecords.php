<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Common\DomainModel\Stub;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IAllWeatherStationRecords, WeatherStation, WeatherStationId, WeatherStationRecord, WeatherStationRecordId
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

	public function purgeWeatherStation(WeatherStation $aStation)
	{
		$qb = $this->em->createQueryBuilder();
		$qb->delete($dqlAlis = 'wsr')->from(WeatherStationRecord::class, $dqlAlis);
		$qb->where("$dqlAlis.weatherStationId = :stationId")->setParameter(':stationId', (string)$aStation->id());
	}

	public function withId(WeatherStation $weatherStation, WeatherStationRecordId $recordId): Stub
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select($dqlAlis = 'wsr')->from(WeatherStationRecord::class, $dqlAlis);
		$qb->where("$dqlAlis.id = :recordId")->setParameter(':recordId', $recordId);
		$qb->andWhere("$dqlAlis.weatherStationId = :stationId")->setParameter(':stationId', (string)$weatherStation->id());
		return Stub::wrap($qb);
	}

	public function totalCount(WeatherStationId $stationId): int
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select('COUNT(wsr.id)')->from(WeatherStationRecord::class, 'wsr');
		$qb->where('wsr.weatherStationId = :wsId')->setParameter(':wsId', $stationId);
		return $qb->getQuery()->getSingleScalarResult();
	}

	public function nextIdentity(): WeatherStationRecordId
	{
		return WeatherStationRecordId::create();
	}

}
