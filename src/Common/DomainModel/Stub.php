<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\DomainModel;

use Adeira\Connector\Common\Infrastructure\DomainModel\{
	ArrayStubProcessor, NullStubProcessor, QueryBuilderStubProcessor
};

final class Stub
{

	/**
	 * @var \Adeira\Connector\Common\DomainModel\IStubProcessor
	 */
	private $stubProcessor;

	private $orientationKey;

	private $orientationDirection;

	private function __construct(IStubProcessor $stubProcessor)
	{
		$this->stubProcessor = $stubProcessor;
	}

	public static function wrap($query): Stub
	{
		if ($query instanceof \Doctrine\ORM\QueryBuilder) {
			return new self(new QueryBuilderStubProcessor($query));
		} elseif ($query === NULL) {
			return new self(new NullStubProcessor);
		} elseif (is_array($query)) {
			return new self(new ArrayStubProcessor($query));
		}
		$class = is_object($query) ? ' (' . get_class($query) . ')' : '';
		throw new \Nette\NotSupportedException('Cannot wrap stub of type ' . gettype($query) . "$class.");
	}

	public function orientation(string $key, string $direction = IStubProcessor::ORIENTATION_ASC): void
	{
		$this->stubProcessor->orientation($key, $direction);
		$this->orientationKey = $key;
		$this->orientationDirection = $direction;
	}

	public function first(int $count): void
	{
		$this->stubProcessor->first($count);
	}

	public function applyExpression(\Doctrine\Common\Collections\Expr\Expression $expression): void
	{
		$this->stubProcessor->applyExpression($expression);
	}

	public function after($identifier): void
	{
		if ($this->orientationKey === NULL || $this->orientationDirection === NULL) {
			throw new \Nette\InvalidStateException('Orientation method must be called first.');
		}
		$this->stubProcessor->after($identifier, $this->orientationKey, $this->orientationDirection);
	}

	public function hydrate($hydrationMode = IStubProcessor::HYDRATE_OBJECT)
	{
		return $this->stubProcessor->hydrate($hydrationMode);
	}

	public function hydrateOne($hydrationMode = IStubProcessor::HYDRATE_OBJECT)
	{
		return $this->stubProcessor->hydrateOne($hydrationMode);
	}

	public function hydrateCount()
	{
		return $this->stubProcessor->hydrateCount();
	}

}
