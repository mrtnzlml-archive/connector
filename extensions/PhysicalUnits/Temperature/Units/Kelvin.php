<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Temperature\Units;

final class Kelvin implements ITemperatureUnit
{

	/**
	 * @var
	 */
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
		return [
			Celsius::class => function (self $kelvin) {
				return new Kelvin($kelvin->value - 273.15); //exact
			},
			Fahrenheit::class => function (self $kelvin) {
				$celsius = $kelvin->value - 273.15;
				return new Fahrenheit(($celsius * 9 / 5) + 32); //exact
			},
		];
	}

}
