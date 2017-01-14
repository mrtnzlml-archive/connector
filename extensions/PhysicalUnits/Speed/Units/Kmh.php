<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Speed\Units;

use Adeira\Connector\PhysicalUnits\IUnit;

class Kmh implements IUnit
{

	public function unitCode(): string
	{
		return 'Kmh';
	}

	public function getConversionTable(): array
	{
		return [];
	}

}
