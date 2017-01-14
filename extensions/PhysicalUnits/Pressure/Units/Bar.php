<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure\Units;

use Adeira\Connector\PhysicalUnits\Pressure\IPressureUnit;

class Bar implements IPressureUnit
{

	public function unitCode(): string
	{
		return 'bar';
	}

	public function getConversionTable(): array
	{
		return [
			'atm' => 1e5 / 101325, //exact
			'Pa' => 1e5, //exact
			'Torr' => (1e5 * 760) / 101325, //exact
		];
	}

}
