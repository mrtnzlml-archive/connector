<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Speed;

use Adeira\Connector\PhysicalUnits\{
	IPhysicalQuantity, IUnit, Pressure\Conversion, Speed\Units\ISpeedUnit
};

/**
 * Exact conversions:
 * 1 m/s = 3.6 km/h
 * 1 mph = 0.44704 m/s
 * 1 mph = 1.609344 km/h
 */
class Speed implements IPhysicalQuantity
{

	/**
	 * @var IUnit
	 */
	private $speedUnit;

	public function __construct(ISpeedUnit $speedUnit)
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
