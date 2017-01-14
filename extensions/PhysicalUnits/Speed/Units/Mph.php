<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Speed\Units;

class Mph implements ISpeedUnit
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
			Kmh::class => function (self $mph) {
				return new Kmh($mph->value * 1.609344); //exact
			},
			Ms::class => function (self $mph) {
				return new Ms($mph->value * 0.44704); //exact
			},
		];
	}

}
