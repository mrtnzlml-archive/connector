<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure\Units;

final class Pascal implements IPressureUnit
{

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
			Atm::class => function (self $pascal) {
				return new Atm($pascal->value / 101325); //exact
			},
			Bar::class => function (self $pascal) {
				return new Bar($pascal->value * 1e-5); //exact
			},
			Torr::class => function (self $pascal) {
				return new Torr($pascal->value * 760 / 101325); //exact
			},
		];
	}

}
