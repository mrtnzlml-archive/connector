<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Devices\DomainModel\WeatherStation\IWeatherStationSeriesRepository;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationSeries;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;

/**
 * Do not call flush() here! Flushing and dealing with transactions is delegated to the Application Service.
 * All behavior should still follow the Repositories’ collection characteristics.
 */
final class DoctrineWeatherStationSeriesRepository implements IWeatherStationSeriesRepository
{

	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	public function __construct(ORM\EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function all(): ArrayCollection
	{
		$qb = $this->em->createQueryBuilder();
		$qb->from(WeatherStationSeries::class, 'series')->select('series');
		return new ArrayCollection($qb->getQuery()->getResult());
	}

}
