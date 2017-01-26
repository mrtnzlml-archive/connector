<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Common\Infrastructure\DomainModel\Doctrine\Specification\ISpecification;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;
use Doctrine\ORM;

class FilterOwner implements ISpecification
{

	private $userId;

	public function __construct(UserId $userId)
	{
		$this->userId = $userId;
	}

	public function match(ORM\QueryBuilder $qb, string $dqlAlias): ORM\Query\Expr\Comparison
	{
		$qb->setParameter(':owner', $this->userId);
		return $qb->expr()->eq("$dqlAlias.owner", ':owner');
	}

	public function isSatisfiedBy(string $candidate): bool
	{
		return $candidate === WeatherStation::class;
	}

}
