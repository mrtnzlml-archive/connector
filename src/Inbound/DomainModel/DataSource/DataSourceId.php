<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\DomainModel\DataSource;

use Ramsey\Uuid\Uuid;

/**
 * This is value object. Value object must be immutable. Object values shouldn’t be able to be altered over their
 * lifetime.
 *
 * Value Objects should be created through their constructors. In order to build one, you usually pass the required
 * primitive types or other Value Objects through this constructor. Value Objects are always in a valid state; that’s
 * why we create them in a single atomic step. Empty constructors with multiple setters and getters move the creation
 * responsibility to the client, resulting in the Anemic Domain Model, which is considered an anti-pattern.
 *
 * As you can see below there is private constructor because there is used semantic constructor ::create. It's because
 * PHP doesn't support __construct overloading (in contrast with e.g. Java) and therefore it's better design to have
 * multiple constructors (factory methods) with their semantic name.
 */
class DataSourceId
{

	private $id;

	private function __construct(string $anId = NULL)
	{
		$this->id = $anId ?: Uuid::uuid4()->toString();
	}

	public static function create($anId = NULL): self
	{
		return new self($anId);
	}

	public function id(): string
	{
		return $this->id;
	}

	public function equals(DataSourceId $id): bool
	{
		return $this->id === $id;
	}

}
