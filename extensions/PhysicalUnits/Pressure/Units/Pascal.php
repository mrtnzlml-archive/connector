<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Pressure\Units;

class Pascal implements IPressureUnit
{

	public function unitCode(): string
	{
		return 'Pa';
	}

	public function getConversionTable(): array
	{
		return [
			'atm' => 1 / 101325, //exact
			'bar' => 1e-5, //exact
			'Torr' => 760 / 101325, //exact
		];
	}

}
