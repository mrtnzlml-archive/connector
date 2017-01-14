<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Speed\Units;

class Kmh implements ISpeedUnit
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
			Mph::class => function (self $kmh) {
				return new Mph($kmh->value / 1.609344); //exact
			},
			Ms::class => function (self $kmh) {
				return new Ms($kmh->value / 3.6); //exact
			},
		];
	}

}
