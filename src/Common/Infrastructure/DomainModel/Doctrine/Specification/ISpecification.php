<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\Infrastructure\DomainModel\Doctrine\Specification;

use Doctrine\ORM;

/**
 * @see: http://www.whitewashing.de/2013/03/04/doctrine_repositories.html
 */
interface ISpecification
{

	public function match(ORM\QueryBuilder $qb, string $dqlAlias);

	/**
	 * Introduce reusability across different repositories by adding functionality to check if a specification supports a given entity.
	 * @see: https://en.wikipedia.org/wiki/Specification_pattern
	 */
	public function isSatisfiedBy(string $candidate): bool;

}
