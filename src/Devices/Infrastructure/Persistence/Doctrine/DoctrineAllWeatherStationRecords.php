<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IAllWeatherStationRecords, WeatherStationId, WeatherStationRecord, WeatherStationRecordId
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

	public function ofWeatherStationId(WeatherStationId $weatherStationId): array
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select('wsr')->from(WeatherStationRecord::class, 'wsr');
		$qb->where('wsr.weatherStationId = :wsid')->setParameter(':wsid', $weatherStationId);
		return $qb->getQuery()->getResult();
	}

	public function ofAllWeatherStationIds(array $weatherStationIds): array
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select('wsr')->from(WeatherStationRecord::class, 'wsr'/*, 'wsr.weatherStationId'*/);
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
