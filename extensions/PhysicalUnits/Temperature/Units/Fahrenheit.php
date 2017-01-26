<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Temperature\Units;

final class Fahrenheit implements ITemperatureUnit
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
			Celsius::class => function (self $fahrenheit) {
				return new Celsius(($fahrenheit->value - 32) * 5 / 9); //exact
			},
			Kelvin::class => function (self $fahrenheit) {
				$celsius = ($fahrenheit->value - 32) * 5 / 9;
				return new Kelvin($celsius + 273.15); //exact
			},
		];
	}

}
