<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Humidity;

use Adeira\Connector\PhysicalUnits\Conversion;
use Adeira\Connector\PhysicalUnits\Humidity\Units\IHumidityUnit;
use Adeira\Connector\PhysicalUnits\IPhysicalQuantity;
use Adeira\Connector\PhysicalUnits\IUnit;

final class RelativeHumidity implements IPhysicalQuantity
{

	/**
	 * @var \Adeira\Connector\PhysicalUnits\IUnit
	 */
	private $speedUnit;

	public function __construct(IHumidityUnit $speedUnit)
	{
		$this->speedUnit = $speedUnit;
	}

	public function value()
	{
		return $this->speedUnit->value();
	}

	public function unit(): IUnit
	{
		return $this->speedUnit;
	}

	public function convertTo(string $speedUnit): IPhysicalQuantity
	{
		$conversion = new Conversion;
		return $conversion->convert($this, $speedUnit);
	}

}
