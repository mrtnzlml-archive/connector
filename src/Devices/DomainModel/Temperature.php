<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel;

use Adeira\Connector\PhysicalUnits\DomainModel\Temperature\Temperature as TemperatureQuantity;
use Adeira\Connector\PhysicalUnits\DomainModel\Temperature\Units\{
	Celsius, ITemperatureUnit
};

final class Temperature
{

	private $indoor;

	private $outdoor;

	public function __construct(?ITemperatureUnit $indoor, ?ITemperatureUnit $outdoor)
	{
		$this->indoor = $indoor ? new TemperatureQuantity($indoor) : NULL;
		$this->outdoor = $outdoor ? new TemperatureQuantity($outdoor) : NULL;
	}

	public function indoor(string $unit = Celsius::class): ?float
	{
		return $this->indoor ? $this->indoor->convertTo($unit)->value() : NULL;
	}

	public function outdoor(string $unit = Celsius::class): ?float
	{
		return $this->outdoor ? $this->outdoor->convertTo($unit)->value() : NULL;
	}

}
