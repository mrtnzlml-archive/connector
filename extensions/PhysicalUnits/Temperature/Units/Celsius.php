<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Temperature\Units;

final class Celsius implements ITemperatureUnit
{

	private $value;

	public function __construct($value)
	{
		$this->value = $value;
	}

	public function value()
	{
		return $this->value;
	}

	public function getConversionTable(): array
	{
		return [
			Kelvin::class => function (self $celsius) {
				return new Kelvin($celsius->value + 273.15); //exact
			},
			Fahrenheit::class => function (self $celsius) {
				return new Fahrenheit(($celsius->value * 9 / 5) + 32); //exact
			},
		];
	}

}
