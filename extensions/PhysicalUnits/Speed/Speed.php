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

	private $speedValue;

	/**
	 * @var IUnit
	 */
	private $speedUnit;

	public function __construct($speedValue, ISpeedUnit $speedUnit)
	{
		$this->speedValue = $speedValue;
		$this->speedUnit = $speedUnit;
	}

	public function getValue()
	{
		return $this->speedValue;
	}

	public function getUnit(): IUnit
	{
		return $this->speedUnit;
	}

	public function convert(IUnit $toSpeedUnit): IPhysicalQuantity
	{
		$conversion = new Conversion;
		return $conversion->convert($this, $toSpeedUnit);
	}

}
