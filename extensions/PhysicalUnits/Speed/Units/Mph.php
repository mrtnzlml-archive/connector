<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Speed\Units;

class Mph implements ISpeedUnit
{

	public function unitCode(): string
	{
		return 'mph';
	}

	public function getConversionTable(): array
	{
		return [
			'kmh' => 1.609344, //exact
			'ms' => 0.44704, //exact
		];
	}

}
