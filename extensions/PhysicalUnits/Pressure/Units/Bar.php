<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure\Units;

class Bar implements IPressureUnit
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
			Atm::class => function (self $bar) {
				return new Atm($bar->value * 1e5 / 101325); //exact
			},
			Pascal::class => function (self $bar) {
				return new Pascal($bar->value * 1e5); //exact
			},
			Torr::class => function (self $bar) {
				return new Torr($bar->value * (1e5 * 760) / 101325); //exact
			},
		];
	}

}
