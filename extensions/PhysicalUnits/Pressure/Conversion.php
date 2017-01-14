<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure;

class Conversion
{

	/**
	 * 1 bar = 100.000 Pa
	 * 1 atm = 101325 Pa = 760 Torr
	 */
	private $conversionTable = [
		'atm' => [
			'bar' => 101325 / 1e5, //exact
			'Pa' => 101325, //exact
			'Torr' => 760, //exact
		],
		'bar' => [
			'atm' => 1e5 / 101325, //exact
			'Pa' => 1e5, //exact
			'Torr' => (1e5 * 760) / 101325, //exact
		],
		'Pa' => [
			'atm' => 1 / 101325, //exact
			'bar' => 1e-5, //exact
			'Torr' => 760 / 101325, //exact
		],
		'Torr' => [
			'atm' => 1 / 760, //exact
			'bar' => 101325 / (1e5 * 760), //exact
			'Pa' => 101325 / 760, //exact
		],
	];

	public function convert(Pressure $fromPressure, IPressureUnit $toPressureUnit): Pressure
	{
		$fromUnit = $fromPressure->getPressureUnit()->unitCode();
		$toUnit = $toPressureUnit->unitCode();
		if ($fromUnit === $toUnit) {
			return new Pressure($fromPressure->getPressureValue(), $fromPressure->getPressureUnit());
		}

		if (!array_key_exists($fromUnit, $this->conversionTable)) {
			throw new \OutOfBoundsException("Unit $fromUnit cannot be converted because conversion is not known.");
		}
		if (!array_key_exists($toUnit, $this->conversionTable[$fromUnit])) {
			throw new \OutOfBoundsException("Unit $toUnit cannot be converted because conversion is not known.");
		}

		return new Pressure($fromPressure->getPressureValue() * $this->conversionTable[$fromUnit][$toUnit], $toPressureUnit);
	}

}
