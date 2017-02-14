<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStationSeries;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationSeries;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;

final class DoctrineAllWeatherStationSeries implements IAllWeatherStationSeries
{

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
