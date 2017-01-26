<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Common\Infrastructure\DomainModel\Doctrine\Specification\ISpecification;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	WeatherStation, WeatherStationId
};
use Doctrine\ORM;

final class FilterWeatherStationsAfter implements ISpecification
{

	private $fromWeatherStationId;

	public function __construct(WeatherStationId $fromWeatherStationId)
	{
		$this->fromWeatherStationId = $fromWeatherStationId;
	}

	public function match(ORM\QueryBuilder $qb, string $dqlAlias): ORM\Query\Expr\Comparison
	{
		$qb->orderBy('ws.deviceName', 'ASC'); // must be ASC because of ->gt(...) call
		$qb->setParameter(':innerId', $this->fromWeatherStationId);
		$expr = $qb->expr()->gt("$dqlAlias.deviceName", '(SELECT wsInner.deviceName FROM ' . WeatherStation::class . ' wsInner WHERE wsInner.id = :innerId)');

		return $expr;
	}

	public function isSatisfiedBy(string $candidate): bool
	{
		return $candidate === WeatherStation::class;
	}

}
