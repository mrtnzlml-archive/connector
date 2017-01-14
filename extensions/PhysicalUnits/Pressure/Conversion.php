<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure;

use Adeira\Connector\PhysicalUnits\{
	IPhysicalQuantity, IUnit
};

class Conversion
{

	public function convert(IPhysicalQuantity $fromPhysicalQuantity, IUnit $toUnit): IPhysicalQuantity
	{
		$fromUnit = $fromPhysicalQuantity->getUnit();
		$fromValue = $fromPhysicalQuantity->getValue();

		if ($fromUnit->unitCode() === $toUnit->unitCode()) {
			return new $fromPhysicalQuantity($fromValue, $fromUnit);
		}

		if (!array_key_exists($toUnit->unitCode(), $fromUnit->getConversionTable())) {
			throw new \OutOfBoundsException("Cannot convert {$fromUnit->unitCode()} -> {$toUnit->unitCode()} because conversion is unknown.");
		}

		return new $fromPhysicalQuantity($fromValue * $fromUnit->getConversionTable()[$toUnit->unitCode()], $toUnit);
	}

}
