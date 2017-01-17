<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\Infrastructure\DomainModel\Doctrine\Specification;

use Doctrine\ORM;

class AndX implements ISpecification
{

	private $wrapped;

	public function __construct(ISpecification ...$wrapped)
	{
		$this->wrapped = $wrapped;
	}

	public function match(ORM\QueryBuilder $qb, string $dqlAlias)//: ORM\Query\Expr
	{
		return call_user_func_array(
			[$qb->expr(), 'andX'],
			array_map(function (ISpecification $specification) use ($qb, $dqlAlias) {
				return $specification->match($qb, $dqlAlias);
			}, $this->wrapped)
		);
	}

	public function isSatisfiedBy(string $candidate): bool
	{
		$satisfied = TRUE;
		foreach ($this->wrapped as $wrap) {
			$satisfied ^= $wrap->isSatisfiedBy($candidate);
		}
		return $satisfied;
	}

}
