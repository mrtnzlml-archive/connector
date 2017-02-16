<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\DomainModel\Humidity;

use Adeira\Connector\PhysicalUnits\DomainModel\{
	Conversion, Humidity\Units\IHumidityUnit, IPhysicalQuantity, IUnit
};

final class RelativeHumidity implements IPhysicalQuantity
{

	private $humidityUnit;

	public function __construct(IHumidityUnit $humidityUnit)
	{
		$this->humidityUnit = $humidityUnit;
	}

	public function value(): float
	{
		return $this->humidityUnit->value();
	}

	public function unit(): IUnit
	{
		return $this->humidityUnit;
	}

	public function convertTo(string $speedUnit): IPhysicalQuantity
	{
		$conversion = new Conversion;
		return $conversion->convert($this, $speedUnit);
	}

}
