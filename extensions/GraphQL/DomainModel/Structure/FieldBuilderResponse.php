<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\DomainModel\Structure;

final class FieldBuilderResponse
{

	/**
	 * @var bool
	 */
	private $isScalar;

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var bool
	 */
	private $nonNull;

	/**
	 * @var bool
	 */
	private $listOf;

	public function __construct(bool $isScalar, string $value, bool $nonNull, bool $listOf)
	{
		$this->isScalar = $isScalar;
		$this->value = $value;
		$this->nonNull = $nonNull;
		$this->listOf = $listOf;
	}

	public function isScalar(): bool
	{
		return $this->isScalar;
	}

	public function isNonNull(): bool
	{
		return $this->nonNull;
	}

	public function isListOf(): bool
	{
		return $this->listOf;
	}

	public function value(): string
	{
		return $this->value;
	}

}
