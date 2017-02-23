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

	public function equals(IdentifiableDomainObject $id): bool
	{
		return $this->toString() === $id->toString();
	}

	public function __toString(): string
	{
		return $this->toString();
	}

	abstract public static function createFromString(string $anId); // without return type so it's possible to add one in childs

}
