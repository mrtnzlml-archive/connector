<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure;

/**
 * 1 bar = 100.000 Pa
 * 1 atm = 101325 Pa = 760 Torr
 */
class Conversion
{

	public function convert(Pressure $fromPressure, IPressureUnit $toPressureUnit): Pressure
	{
		$fromUnit = $fromPressure->getPressureUnit();
		$fromValue = $fromPressure->getPressureValue();

		if ($fromUnit->unitCode() === $toPressureUnit->unitCode()) {
			return new Pressure($fromValue, $fromUnit);
		}

		if (!array_key_exists($toPressureUnit->unitCode(), $fromUnit->getConversionTable())) {
			throw new \OutOfBoundsException("Cannot covert {$fromUnit->unitCode()} to {$toPressureUnit->unitCode()} because conversion is not known.");
		}

		return new Pressure($fromValue * $fromUnit->getConversionTable()[$toPressureUnit->unitCode()], $toPressureUnit);
	}

}
