<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Common\Infrastructure\DomainModel\Doctrine\Specification\ISpecification;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;
use Doctrine\ORM;

final class FilterOwner implements ISpecification
{

	private $owner;

	public function __construct(Owner $owner)
	{
		$this->owner = $owner;
	}

	public function match(ORM\QueryBuilder $qb, string $dqlAlias): ORM\Query\Expr\Comparison
	{
		$qb->setParameter(':owner', (string)$this->owner->id());
		return $qb->expr()->eq("$dqlAlias.owner", ':owner');
	}

	public function isSatisfiedBy(string $candidate): bool
	{
		return $candidate === WeatherStation::class;
	}

}
