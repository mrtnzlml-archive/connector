<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Temperature\Units;

class Kelvin implements ITemperatureUnit
{

	public function unitCode(): string
	{
		return 'K';
	}

	public function getConversionTable(): array
	{
		return [];
	}

}
