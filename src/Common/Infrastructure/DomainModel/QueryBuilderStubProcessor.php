<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\Infrastructure\DomainModel;

use Adeira\Connector\Common\DomainModel\IStubProcessor;

final class QueryBuilderStubProcessor implements IStubProcessor
{

	/**
	 * @var \Doctrine\ORM\QueryBuilder
	 */
	private $qb;

	public function __construct(\Doctrine\ORM\QueryBuilder $qb)
	{
		$this->qb = $qb;
	}

	public function orientation(string $key, string $direction = self::ORIENTATION_ASC): void
	{
		$rootAlias = $this->qb->getRootAliases()[0]; //FIXME: may be fragile!
		$this->qb->orderBy("$rootAlias.$key", $direction);
	}

	public function first(int $count): void
	{
		$this->qb->setMaxResults($count);
	}

	public function after($identifier, string $orientationKey, string $orientationValue): void
	{
		$rootAlias = $this->qb->getRootAliases()[0]; //FIXME: may be fragile!
		$rootEntity = $this->qb->getRootEntities()[0]; //FIXME: may be fragile!
		$direction = $orientationValue === self::ORIENTATION_ASC ? 'gt' : 'lt'; // must be ASC for ->gt(...) call

		$expr = $this->qb->expr()->$direction(
			"$rootAlias.$orientationKey",
			"(SELECT inn.$orientationKey FROM $rootEntity inn WHERE inn.id = :innerId)"
		);
		$this->qb->setParameter(':innerId', $identifier);
		$this->qb->andWhere($expr);
	}

	public function applyExpression(\Doctrine\Common\Collections\Expr\Expression $expression): void
	{
		$visitor = new \Doctrine\ORM\Query\QueryExpressionVisitor($this->qb->getRootAliases());
		$this->qb->andWhere($expression->visit($visitor));
		/** @var \Doctrine\ORM\Query\Parameter $parameter */
		foreach ($visitor->getParameters() as $parameter) {
			$this->qb->setParameter($parameter->getName(), $parameter->getValue(), $parameter->getType());
		}
	}

	// HYDRATATION:

	public function hydrate($hydrationMode = self::HYDRATE_OBJECT)
	{
		return $this->qb->getQuery()->getResult($hydrationMode);
	}

	public function hydrateOne($hydrationMode = self::HYDRATE_OBJECT)
	{
		return $this->qb->getQuery()->getSingleResult($hydrationMode);
	}

	public function hydrateCount()
	{
		$rootAlias = $this->qb->getRootAliases()[0]; //FIXME: may be fragile!
		$this->qb->select("COUNT($rootAlias)");
		return $this->hydrate(IStubProcessor::HYDRATE_SINGLE_SCALAR);
	}

}
