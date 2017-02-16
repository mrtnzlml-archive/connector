<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\DomainModel\Humidity\Units;

final class Percentage implements IHumidityUnit
{

	private $value;

	public function __construct($value)
	{
		$this->value = $value;
	}

	public function value(): float
	{
		return (float)$this->value;
	}

	public function getConversionTable(): array
	{
		return [];
	}

}
