<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\Infrastructure\DomainModel;

use Adeira\Connector\Common\DomainModel\IStubProcessor;

final class ArrayStubProcessor implements IStubProcessor
{

	/**
	 * @var array
	 */
	private $stub;

	public function __construct(array $stub)
	{
		$this->stub = $stub;
	}

	public function orientation(string $key, string $direction = self::ORIENTATION_ASC): void
	{
		throw new \Nette\NotSupportedException;
	}

	public function first(int $count): void
	{
		$this->stub = array_slice($this->stub, 0, $count);
	}

	public function after($identifier, string $orientationKey, string $orientationValue): void
	{
		throw new \Nette\NotSupportedException;
	}

	public function applyExpression(\Doctrine\Common\Collections\Expr\Expression $expression): void
	{
		throw new \Nette\NotSupportedException;
	}

	// HYDRATATION:

	public function hydrate($hydrationMode = self::HYDRATE_ARRAY) //FIXME: array only
	{
		return $this->stub;
	}

	public function hydrateOne($hydrationMode = self::HYDRATE_ARRAY) //FIXME: array only
	{
		$sliced = array_slice($this->stub, 0, 1);
		return $sliced[key($sliced)] ?? NULL;
	}

	public function hydrateCount()
	{
		return count($this->stub);
	}

}
