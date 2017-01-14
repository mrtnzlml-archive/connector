<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Temperature\Units;

class Celsius implements ITemperatureUnit
{

	public function unitCode(): string
	{
		return 'C';
	}

	public function getConversionTable(): array
	{
		return [];
	}

}
