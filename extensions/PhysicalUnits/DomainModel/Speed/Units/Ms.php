<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\DomainModel\Speed\Units;

final class Ms implements ISpeedUnit
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
			Kmh::class => function (self $ms) {
				return new Kmh($ms->value * 3.6); //exact
			},
			Mph::class => function (self $ms) {
				return new Mph($ms->value / 0.44704); //exact
			},
		];
	}

}
