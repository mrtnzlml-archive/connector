<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\DomainModel;

interface IStubProcessor
{

	public const ORIENTATION_ASC = 'ASC';
	public const ORIENTATION_DESC = 'DESC';

	//FIXME:
	public const HYDRATE_OBJECT = \Doctrine\ORM\AbstractQuery::HYDRATE_OBJECT;
	public const HYDRATE_ARRAY = \Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY;
	public const HYDRATE_SINGLE_SCALAR = \Doctrine\ORM\AbstractQuery::HYDRATE_SINGLE_SCALAR;

	// MANIPULATORS:

	public function orientation(string $key, string $direction = self::ORIENTATION_ASC): void;

	public function first(int $count): void;

	public function after($identifier, string $orientationKey, string $orientationValue): void;

	public function applyExpression(\Doctrine\Common\Collections\Expr\Expression $expression): void;

	// HYDRATATION:

	public function hydrate($hydrationMode = self::HYDRATE_OBJECT);

	public function hydrateOne($hydrationMode = self::HYDRATE_OBJECT);

	public function hydrateCount();

}
