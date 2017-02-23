<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\DomainModel;

abstract class IdentifiableDomainObject
{

	/**
	 * @var string
	 */
	private $id;

	public function toString(): string
	{
		return $this->id;
	}

	public function setId(string $anId)
	{
		$this->id = $anId;
	}

	public function __toString(): string
	{
		return $this->toString();
	}

	abstract public function equals(IdentifiableDomainObject $id): bool;

}
