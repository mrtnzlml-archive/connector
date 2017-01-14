<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure\Units;

class Torr implements IPressureUnit
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
			Atm::class => function (self $torr) {
				return new Atm($torr->value / 760); //exact
			},
			Bar::class => function (self $torr) {
				return new Bar($torr->value * 101325 / (1e5 * 760)); //exact
			},
			Pascal::class => function (self $torr) {
				return new Pascal($torr->value * 101325 / 760); //exact
			},
		];
	}

}
