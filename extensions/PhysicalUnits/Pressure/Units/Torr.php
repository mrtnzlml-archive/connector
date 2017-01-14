<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure\Units;

use Adeira\Connector\PhysicalUnits\IUnit;

class Torr implements IUnit
{

	public function unitCode(): string
	{
		return 'Torr';
	}

	public function getConversionTable(): array
	{
		return [
			'atm' => 1 / 760, //exact
			'bar' => 101325 / (1e5 * 760), //exact
			'Pa' => 101325 / 760, //exact
		];
	}

}
