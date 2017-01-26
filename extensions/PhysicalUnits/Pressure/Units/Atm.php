<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure\Units;

final class Atm implements IPressureUnit
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
			Bar::class => function (self $atm) {
				return new Bar($atm->value * 101325 / 1e5); //exact
			},
			Pascal::class => function (self $atm) {
				return new Pascal($atm->value * 101325); //exact
			},
			Torr::class => function (self $atm) {
				return new Torr($atm->value * 760); //exact
			},
		];
	}

}
