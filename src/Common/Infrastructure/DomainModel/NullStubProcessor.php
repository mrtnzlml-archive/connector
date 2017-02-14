<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\Infrastructure\DomainModel;

use Adeira\Connector\Common\DomainModel\IStubProcessor;

final class NullStubProcessor implements IStubProcessor
{

	public function orientation(string $key, string $direction = self::ORIENTATION_ASC): void
	{
	}

	public function first(int $count): void
	{
	}

	public function after($identifier, string $orientationKey, string $orientationValue): void
	{
	}

	public function applyExpression(\Doctrine\Common\Collections\Expr\Expression $expression): void
	{
	}

	// HYDRATATION:

	public function hydrate($hydrationMode = self::HYDRATE_OBJECT)
	{
		return NULL;
	}

	public function hydrateOne($hydrationMode = self::HYDRATE_OBJECT)
	{
		return NULL;
	}

	public function hydrateCount()
	{
		return NULL;
	}

}
