<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IWeatherStationRecordRepository,
	WeatherStationId,
	WeatherStationRecord,
	WeatherStationRecordId
};
use Doctrine\ORM;

/**
 * Do not call flush() here! Flushing and dealing with transactions is delegated to the Application Service.
 * All behavior should still follow the Repositories’ collection characteristics.
 */
final class DoctrineWeatherStationRecordRepository implements IWeatherStationRecordRepository
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

	public function ofId(WeatherStationRecordId $weatherStationRecordId)
	{
		// TODO: Implement ofId() method.
	}

	public function ofWeatherStationId(WeatherStationId $weatherStationId): array
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select('wsr')->from(WeatherStationRecord::class, 'wsr');
		$qb->where('wsr.weatherStationId = :wsid')->setParameter(':wsid', $weatherStationId);
		return $qb->getQuery()->getResult();
	}

	public function nextIdentity(): WeatherStationRecordId
	{
		return WeatherStationRecordId::create();
	}

}
