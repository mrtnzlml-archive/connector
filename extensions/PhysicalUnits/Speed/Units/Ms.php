<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Speed\Units;

class Ms implements ISpeedUnit
{

	public function unitCode(): string
	{
		return 'ms';
	}

	public function getConversionTable(): array
	{
		return [
			'kmh' => 3.6, //exact
			'mph' => 1 / 0.44704, //exact
		];
	}

}
