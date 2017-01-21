<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\Infrastructure\DomainModel\Doctrine\Specification;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class Executor
{

	public static function prepareQueryBuilder(
		EntityManagerInterface $em,
		ISpecification $specification,
		string $entityName,
		string $dqlAlias
	): QueryBuilder {
		$queryBuilder = $em->createQueryBuilder();
		$queryBuilder->select($dqlAlias)->from($entityName, $dqlAlias);

		if (!$specification->isSatisfiedBy($entityName)) {
			throw new \InvalidArgumentException('Specification not supported by this repository.');
		}

		$expr = $specification->match($queryBuilder, $dqlAlias);
		if ($expr !== NULL) {
			$queryBuilder->andWhere($expr);
		}

		return $queryBuilder;
	}

}
