<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Temperature\Units;

class Fahrenheit implements ITemperatureUnit
{

	public function unitCode(): string
	{
		return 'F';
	}

	public function getConversionTable(): array
	{
		return [];
	}

}
