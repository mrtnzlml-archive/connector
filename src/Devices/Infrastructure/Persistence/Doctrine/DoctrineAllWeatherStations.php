<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Common\DomainModel\Stub;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IAllWeatherStations, WeatherStation, WeatherStationId
};
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\ORM;

/**
 * Do not call flush() here! Flushing and dealing with transactions is delegated to the Application Service.
 * All behavior should still follow the Repositories’ collection characteristics.
 */
final class DoctrineAllWeatherStations implements IAllWeatherStations
{

	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	public function __construct(ORM\EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function add(WeatherStation $aWeatherStation): void
	{
		$this->em->persist($aWeatherStation);
	}

	public function withId(Owner $owner, WeatherStationId $weatherStationId): Stub
	{
		$result = $this->belongingTo($owner);
		$result->applyExpression(
			new Comparison('ws.id', Comparison::EQ, $weatherStationId)
		);
		return $result;
	}

	public function belongingTo(Owner $owner): Stub
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select($dqlAlias = 'ws')->from(WeatherStation::class, $dqlAlias);
		$qb->andWhere('ws.ownerId = :ownerId')->setParameter(':ownerId', (string)$owner->id());

		return Stub::wrap($qb);
	}

	public function nextIdentity(): WeatherStationId
	{
		return WeatherStationId::create();
	}

}
